<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            BrandSeeder::class,
            KategoriSeeder::class,
        ]);

        // Seeder untuk Admin
        User::firstOrCreate(
            ['email' => 'admin@salza.com'],
            [
                'name' => 'Administrator',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'admin',
                'phone' => '081234567890',
            ]
        );

        // Seeder untuk Pelanggan
        User::firstOrCreate(
            ['email' => 'pelanggan@salza.com'],
            [
                'name' => 'Pelanggan Setia',
                'password' => \Illuminate\Support\Facades\Hash::make('password123'),
                'role' => 'pelanggan',
                'phone' => '089876543210',
            ]
        );
    }
}
