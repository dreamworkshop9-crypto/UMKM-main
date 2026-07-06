<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            'Sneakers',
            'Running',
            'Casual',
            'Formal',
            'Sport',
            'Boot',
        ];

        foreach ($kategoris as $name) {
            Kategori::firstOrCreate(
                ['slug' => Str::slug($name)],
                ['name' => $name, 'description' => 'Kategori otomatis dari seeder.']
            );
        }
    }
}
