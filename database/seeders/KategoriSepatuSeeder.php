<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSepatuSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            ['name' => 'Sepatu Kasual',  'slug' => 'sepatu-kasual',  'description' => 'Sepatu untuk kegiatan sehari-hari yang nyaman dan stylish'],
            ['name' => 'Sepatu Formal',   'slug' => 'sepatu-formal',   'description' => 'Sepatu untuk acara formal dan profesional'],
            ['name' => 'Sepatu Olahraga', 'slug' => 'sepatu-olahraga', 'description' => 'Sepatu dirancang khusus untuk aktivitas olahraga'],
            ['name' => 'Sepatu Boots',    'slug' => 'sepatu-boots',    'description' => 'Sepatu tinggi untuk perlindungan dan gaya rugged'],
        ];

        foreach ($data as $item) {
            Kategori::firstOrCreate(
                ['slug' => $item['slug']],
                $item
            );
        }

        $this->command->info('4 kategori sepatu berhasil ditambahkan.');
    }
}
