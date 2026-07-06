<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('produks', function (Blueprint $table) {
            if (!Schema::hasColumn('produks', 'old_price')) {
                $table->unsignedBigInteger('old_price')->nullable()->after('price');
            }
            if (!Schema::hasColumn('produks', 'thumbnail')) {
                $table->string('thumbnail')->nullable()->after('price');
            }
            if (!Schema::hasColumn('produks', 'sku')) {
                $table->string('sku')->nullable()->unique()->after('thumbnail');
            }
            if (!Schema::hasColumn('produks', 'weight')) {
                $table->unsignedInteger('weight')->nullable()->after('sku');
            }
            if (!Schema::hasColumn('produks', 'subcategory_id')) {
                $table->unsignedBigInteger('subcategory_id')->nullable()->after('kategori_id');
            }
            if (!Schema::hasColumn('produks', 'subsubcategory_id')) {
                $table->unsignedBigInteger('subsubcategory_id')->nullable()->after('subcategory_id');
            }
            if (!Schema::hasColumn('produks', 'is_new')) {
                $table->boolean('is_new')->default(false)->after('is_active');
            }
            if (!Schema::hasColumn('produks', 'is_best_seller')) {
                $table->boolean('is_best_seller')->default(false)->after('is_new');
            }
        });
    }

    public function down(): void {
        Schema::table('produks', function (Blueprint $table) {
            foreach (['old_price','thumbnail','sku','weight','subcategory_id','subsubcategory_id','is_new','is_best_seller'] as $column) {
                if (Schema::hasColumn('produks', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
