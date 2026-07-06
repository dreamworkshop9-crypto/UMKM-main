<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $methods = PaymentMethod::all()->keyBy('code');
        return view('admin.payment.index', compact('methods'));
    }

    public function update(Request $request)
    {
        // 1. Update Transfer Bank
        $transfer = PaymentMethod::where('code', 'transfer')->first();
        if ($transfer) {
            $transfer->is_active = $request->has('transfer_active');
            
            $banks = [];
            if ($request->has('bank_name')) {
                foreach ($request->bank_name as $index => $name) {
                    if (!empty($name)) {
                        $banks[] = [
                            'bank' => $name,
                            'account_number' => $request->bank_account[$index] ?? '',
                            'account_name' => $request->bank_holder[$index] ?? '',
                        ];
                    }
                }
            }
            $transfer->details = $banks;
            $transfer->save();
        }

        // 2. Update COD
        $cod = PaymentMethod::where('code', 'cod')->first();
        if ($cod) {
            $cod->is_active = $request->has('cod_active');
            $cod->details = [
                'description' => $request->cod_description ?? 'Bayar di tempat saat barang sampai.'
            ];
            $cod->save();
        }

        // 3. Update E-Wallet / QRIS
        $ewallet = PaymentMethod::where('code', 'ewallet')->first();
        if ($ewallet) {
            $ewallet->is_active = $request->has('ewallet_active');
            
            $details = $ewallet->details ?? [];
            $details['phone'] = $request->ewallet_phone ?? '';
            $details['account_name'] = $request->ewallet_holder ?? '';

            if ($request->hasFile('ewallet_qris')) {
                $file = $request->file('ewallet_qris');
                $filename = 'qris_' . time() . '.' . $file->getClientOriginalExtension();
                
                // Ensure directory exists
                if (!file_exists(public_path('uploads/payment'))) {
                    mkdir(public_path('uploads/payment'), 0777, true);
                }
                
                $file->move(public_path('uploads/payment'), $filename);
                $details['qris_image'] = '/uploads/payment/' . $filename;
            }

            $ewallet->details = $details;
            $ewallet->save();
        }

        return back()->with('success', 'Metode pembayaran berhasil diperbarui.');
    }
}
