<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->string('province_code');
            $table->string('province_name');
            $table->string('courier');
            $table->integer('cost');
            $table->string('estimation')->default('2-3 Hari');
            $table->timestamps();

            $table->unique(['province_code', 'courier']);
        });

        // Populate with default rates
        $provinces = [
            'aceh'             => 'Aceh',
            'sumatera-utara'   => 'Sumatera Utara',
            'sumatera-barat'   => 'Sumatera Barat',
            'riau'             => 'Riau',
            'kepulauan-riau'   => 'Kepulauan Riau (Kepri)',
            'jambi'            => 'Jambi',
            'bengkulu'         => 'Bengkulu',
            'sumatera-selatan' => 'Sumatera Selatan',
            'bangka-belitung'  => 'Kepulauan Bangka Belitung',
            'lampung'          => 'Lampung',
            'dki-jakarta'      => 'DKI Jakarta',
            'banten'           => 'Banten',
            'jawa-barat'       => 'Jawa Barat',
            'jawa-tengah'      => 'Jawa Tengah',
            'diy-yogyakarta'   => 'DI Yogyakarta',
            'jawa-timur'       => 'Jawa Timur',
            'bali'             => 'Bali',
            'ntb'              => 'Nusa Tenggara Barat (NTB)',
            'ntt'              => 'Nusa Tenggara Timur (NTT)',
            'kalimantan-barat' => 'Kalimantan Barat',
            'kalimantan-tengah'=> 'Kalimantan Tengah',
            'kalimantan-selatan'=> 'Kalimantan Selatan',
            'kalimantan-timur' => 'Kalimantan Timur',
            'kalimantan-utara' => 'Kalimantan Utara',
            'sulawesi-utara'   => 'Sulawesi Utara',
            'gorontalo'        => 'Gorontalo',
            'sulawesi-tengah'  => 'Sulawesi Tengah',
            'sulawesi-barat'   => 'Sulawesi Barat',
            'sulawesi-selatan' => 'Sulawesi Selatan',
            'sulawesi-tenggara'=> 'Sulawesi Tenggara',
            'maluku'           => 'Maluku',
            'maluku-utara'     => 'Maluku Utara',
            'papua-barat'      => 'Papua Barat',
            'papua'            => 'Papua',
            'papua-tengah'     => 'Papua Tengah',
            'papua-pegunungan' => 'Papua Pegunungan',
            'papua-selatan'    => 'Papua Selatan',
            'papua-barat-daya' => 'Papua Barat Daya',
        ];

        $rates = [
            'aceh'             => ['jne' => [30000, '4-6 Hari'], 'jnt' => [25000, '4-7 Hari'], 'sicepat' => [22000, '5-8 Hari']],
            'sumatera-utara'   => ['jne' => [30000, '3-5 Hari'], 'jnt' => [25000, '3-6 Hari'], 'sicepat' => [22000, '4-7 Hari']],
            'sumatera-barat'   => ['jne' => [30000, '3-5 Hari'], 'jnt' => [25000, '3-6 Hari'], 'sicepat' => [22000, '4-7 Hari']],
            'riau'             => ['jne' => [30000, '3-5 Hari'], 'jnt' => [25000, '3-6 Hari'], 'sicepat' => [22000, '4-7 Hari']],
            'kepulauan-riau'   => ['jne' => [32000, '3-5 Hari'], 'jnt' => [28000, '4-6 Hari'], 'sicepat' => [24000, '4-7 Hari']],
            'jambi'            => ['jne' => [30000, '3-5 Hari'], 'jnt' => [25000, '3-6 Hari'], 'sicepat' => [22000, '4-7 Hari']],
            'bengkulu'         => ['jne' => [30000, '3-5 Hari'], 'jnt' => [25000, '3-6 Hari'], 'sicepat' => [22000, '4-7 Hari']],
            'sumatera-selatan' => ['jne' => [30000, '2-4 Hari'], 'jnt' => [25000, '3-5 Hari'], 'sicepat' => [22000, '3-6 Hari']],
            'bangka-belitung'  => ['jne' => [32000, '3-5 Hari'], 'jnt' => [28000, '4-6 Hari'], 'sicepat' => [24000, '4-7 Hari']],
            'lampung'          => ['jne' => [25000, '2-3 Hari'], 'jnt' => [22000, '2-4 Hari'], 'sicepat' => [19000, '3-5 Hari']],
            'dki-jakarta'      => ['jne' => [10000, '1-2 Hari'], 'jnt' => [8000, '1-2 Hari'],  'sicepat' => [7000, '1-2 Hari']],
            'banten'           => ['jne' => [12000, '1-2 Hari'], 'jnt' => [10000, '1-3 Hari'], 'sicepat' => [9000, '1-3 Hari']],
            'jawa-barat'       => ['jne' => [15000, '1-2 Hari'], 'jnt' => [12000, '1-3 Hari'], 'sicepat' => [10000, '2-3 Hari']],
            'jawa-tengah'      => ['jne' => [18000, '2-3 Hari'], 'jnt' => [15000, '2-4 Hari'], 'sicepat' => [13000, '2-4 Hari']],
            'diy-yogyakarta'   => ['jne' => [18000, '2-3 Hari'], 'jnt' => [15000, '2-4 Hari'], 'sicepat' => [13000, '2-4 Hari']],
            'jawa-timur'       => ['jne' => [20000, '2-3 Hari'], 'jnt' => [17000, '2-4 Hari'], 'sicepat' => [14000, '2-4 Hari']],
            'bali'             => ['jne' => [30000, '3-4 Hari'], 'jnt' => [25000, '3-5 Hari'], 'sicepat' => [22000, '3-5 Hari']],
            'ntb'              => ['jne' => [35000, '3-5 Hari'], 'jnt' => [30000, '4-6 Hari'], 'sicepat' => [25000, '4-6 Hari']],
            'ntt'              => ['jne' => [40000, '4-6 Hari'], 'jnt' => [35000, '4-7 Hari'], 'sicepat' => [30000, '5-8 Hari']],
            'kalimantan-barat' => ['jne' => [40000, '3-5 Hari'], 'jnt' => [35000, '4-6 Hari'], 'sicepat' => [30000, '4-7 Hari']],
            'kalimantan-tengah'=> ['jne' => [40000, '3-5 Hari'], 'jnt' => [35000, '4-6 Hari'], 'sicepat' => [30000, '4-7 Hari']],
            'kalimantan-selatan'=> ['jne' => [40000, '3-5 Hari'], 'jnt' => [35000, '4-6 Hari'], 'sicepat' => [30000, '4-7 Hari']],
            'kalimantan-timur' => ['jne' => [40000, '3-5 Hari'], 'jnt' => [35000, '4-6 Hari'], 'sicepat' => [30000, '4-7 Hari']],
            'kalimantan-utara' => ['jne' => [42000, '4-6 Hari'], 'jnt' => [38000, '4-7 Hari'], 'sicepat' => [32000, '5-8 Hari']],
            'sulawesi-utara'   => ['jne' => [45000, '4-6 Hari'], 'jnt' => [38000, '4-7 Hari'], 'sicepat' => [35000, '5-8 Hari']],
            'gorontalo'        => ['jne' => [45000, '4-6 Hari'], 'jnt' => [38000, '4-7 Hari'], 'sicepat' => [35000, '5-8 Hari']],
            'sulawesi-tengah'  => ['jne' => [45000, '4-6 Hari'], 'jnt' => [38000, '4-7 Hari'], 'sicepat' => [35000, '5-8 Hari']],
            'sulawesi-barat'   => ['jne' => [45000, '4-6 Hari'], 'jnt' => [38000, '4-7 Hari'], 'sicepat' => [35000, '5-8 Hari']],
            'sulawesi-selatan' => ['jne' => [42000, '3-5 Hari'], 'jnt' => [36000, '4-6 Hari'], 'sicepat' => [32000, '4-7 Hari']],
            'sulawesi-tenggara'=> ['jne' => [45000, '4-6 Hari'], 'jnt' => [38000, '4-7 Hari'], 'sicepat' => [35000, '5-8 Hari']],
            'maluku'           => ['jne' => [55000, '5-7 Hari'], 'jnt' => [50000, '5-8 Hari'], 'sicepat' => [45000, '6-9 Hari']],
            'maluku-utara'     => ['jne' => [55000, '5-7 Hari'], 'jnt' => [50000, '5-8 Hari'], 'sicepat' => [45000, '6-9 Hari']],
            'papua-barat'      => ['jne' => [60000, '5-8 Hari'], 'jnt' => [55000, '6-9 Hari'], 'sicepat' => [50000, '6-10 Hari']],
            'papua'            => ['jne' => [60000, '5-8 Hari'], 'jnt' => [55000, '6-9 Hari'], 'sicepat' => [50000, '6-10 Hari']],
            'papua-tengah'     => ['jne' => [60000, '5-8 Hari'], 'jnt' => [55000, '6-9 Hari'], 'sicepat' => [50000, '6-10 Hari']],
            'papua-pegunungan' => ['jne' => [65000, '6-9 Hari'], 'jnt' => [60000, '6-10 Hari'], 'sicepat' => [55000, '7-11 Hari']],
            'papua-selatan'    => ['jne' => [60000, '5-8 Hari'], 'jnt' => [55000, '6-9 Hari'], 'sicepat' => [50000, '6-10 Hari']],
            'papua-barat-daya' => ['jne' => [60000, '5-8 Hari'], 'jnt' => [55000, '6-9 Hari'], 'sicepat' => [50000, '6-10 Hari']],
        ];

        $inserts = [];
        $now = now();

        foreach ($rates as $pCode => $couriers) {
            foreach ($couriers as $cour => $info) {
                $inserts[] = [
                    'province_code' => $pCode,
                    'province_name' => $provinces[$pCode] ?? ucfirst($pCode),
                    'courier'       => $cour,
                    'cost'          => $info[0],
                    'estimation'    => $info[1],
                    'created_at'    => $now,
                    'updated_at'    => $now,
                ];
            }
        }

        DB::table('shipping_rates')->insert($inserts);
    }

    public function down(): void
    {
        Schema::dropIfExists('shipping_rates');
    }
};
