<?php

namespace App\Services;

use App\Models\Order;
use Midtrans\Config;
use Midtrans\Snap;

class MidtransService
{
    public function __construct()
    {
        Config::$serverKey    = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);
        Config::$isSanitized  = true;
        Config::$is3ds        = true;
    }

    public function buildPayload(Order $order, $cartItems): array
    {
        $itemDetails = $cartItems->map(fn ($item) => [
            'id'       => $item->produk_id,
            'price'    => (int) $item->harga,
            'quantity' => $item->qty,
            'name'     => $item->produk->name . ' (' . ($item->ukuran ?? '-') . ')',
        ])->toArray();

        $itemDetails[] = [
            'id'       => 'ONGKIR-' . $order->id,
            'price'    => (int) $order->ongkir,
            'quantity' => 1,
            'name'     => 'Ongkos Kirim',
        ];

        return [
            'transaction_details' => [
                'order_id'     => $order->code,
                'gross_amount' => (int) $order->total,
            ],
            'item_details'     => $itemDetails,
            'customer_details' => [
                'first_name' => $order->user->name,
                'email'      => $order->user->email,
                'phone'      => $order->user->whatsapp ?? '',
            ],
            'callbacks' => [
                'finish'   => route('payment.finish'),
                'error'    => route('payment.error'),
                'unfinish' => route('payment.unfinish'),
            ],
        ];
    }

    public function createTransaction(array $payload)
    {
        try {
            $snapToken = Snap::getSnapToken($payload);

            return (object) [
                'token'        => $snapToken,
                'redirect_url' => null,
                'va_number'    => null,
                'qr_url'       => null,
            ];
        } catch (\Exception $e) {
            \Log::error('Midtrans Error: ' . $e->getMessage());
            throw new \Exception('Gagal membuat transaksi pembayaran');
        }
    }

    public function handleNotification(Request $request): array
    {
        $notif = new \Midtrans\Notification();

        return [
            'order_id'           => $notif->order_id,
            'transaction_status' => $notif->transaction_status,
            'payment_type'       => $notif->payment_type,
            'fraud_status'       => $notif->fraud_status ?? null,
        ];
    }
}