<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Adidas', 'Fila', 'Puma', 'Champion', 'Vans',
            'Nike', 'Converse', 'New Balance', 'Reebok', 'Under Armour',
        ];

        foreach ($brands as $name) {
            Brand::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($name)],
                ['name' => $name, 'image' => null]
            );
        }
    }
}