<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        PaymentMethod::updateOrCreate(
            ['code' => 'transfer'],
            [
                'name' => 'Transfer Bank',
                'is_active' => true,
                'details' => [
                    [
                        'bank' => 'BCA',
                        'account_number' => '123-456-7890',
                        'account_name' => 'ShoesMarket',
                    ],
                    [
                        'bank' => 'Mandiri',
                        'account_number' => '987-654-3210',
                        'account_name' => 'ShoesMarket',
                    ]
                ]
            ]
        );

        PaymentMethod::updateOrCreate(
            ['code' => 'cod'],
            [
                'name' => 'COD (Bayar di Tempat)',
                'is_active' => true,
                'details' => [
                    'description' => 'Bayar dengan uang tunai langsung ke kurir saat pesanan Anda sampai di alamat pengiriman.'
                ]
            ]
        );

        PaymentMethod::updateOrCreate(
            ['code' => 'ewallet'],
            [
                'name' => 'E-Wallet (QRIS)',
                'is_active' => true,
                'details' => [
                    'qris_image' => '/images/qris_mockup.png',
                    'phone' => '0812-3456-7890',
                    'account_name' => 'ShoesMarket',
                ]
            ]
        );
    }
}
