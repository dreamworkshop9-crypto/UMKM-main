<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function notification(Request $request)
    {
        $midtrans = new MidtransService();
        $status   = $midtrans->handleNotification($request);

        $order = Order::where('code', $status['order_id'])
            ->orWhere('id', $status['order_id'])
            ->first();

        if (! $order) {
            return response('Order not found', 404);
        }

        $txStatus = $status['transaction_status'];

        if (in_array($txStatus, ['capture', 'settlement'])) {
            if ($order->status !== 'dikonfirmasi') {
                foreach ($order->items as $item) {
                    if ($item->produk) {
                        $item->produk->decrement('stock', $item->quantity);
                    }
                }
            }
            $order->update([
                'status'         => 'dikonfirmasi',
                'payment_status' => 'paid',
                'payment_type'   => $status['payment_type'] ?? null,
                'paid_at'        => now(),
            ]);
        } elseif ($txStatus === 'pending') {
            $order->update([
                'status'         => 'menunggu',
                'payment_status' => 'unpaid'
            ]);
        } elseif (in_array($txStatus, ['deny', 'expire', 'cancel'])) {
            $order->update([
                'status'         => 'dibatalkan',
                'payment_status' => 'failed'
            ]);
        }

        return response('OK', 200);
    }

    public function success(Request $r)  { return $this->showResult($r); }
    public function finish(Request $r)   { return $this->showResult($r); }
    public function unfinish(Request $r) { return $this->showResult($r); }
    public function error(Request $r)   { return $this->showResult($r); }

    private function showResult(Request $r)
    {
        $order = Order::where('code', $r->order_id)->first();
        return view('front.payment.result', compact('order'));
    }
}