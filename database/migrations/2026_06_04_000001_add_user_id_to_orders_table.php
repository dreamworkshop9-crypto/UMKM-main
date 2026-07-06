<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (! Schema::hasColumn('orders', 'user_id')) {
                $table->foreignId('user_id')->nullable()->after('id')->constrained('users')->nullOnDelete();
            }
        });

        DB::statement('DROP VIEW IF EXISTS products');
        DB::statement('CREATE VIEW products AS SELECT id, name, slug, description, brand_id, kategori_id, price AS harga, stock AS stok, image, old_price, thumbnail, sku, weight, subcategory_id, subsubcategory_id, is_active, is_new, is_best_seller, created_at, updated_at FROM produks');
    }

    public function down(): void
    {
        DB::statement('DROP VIEW IF EXISTS products');

        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'user_id')) {
                $table->dropConstrainedForeignId('user_id');
            }
        });
    }
};
