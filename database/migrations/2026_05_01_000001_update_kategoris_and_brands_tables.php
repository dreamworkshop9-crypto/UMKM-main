<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('kategoris', function (Blueprint $table) {
            if (!Schema::hasColumn('kategoris', 'parent_id')) {
                $table->foreignId('parent_id')->nullable()->after('slug')->constrained('kategoris')->nullOnDelete();
            }
            if (!Schema::hasColumn('kategoris', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });
        Schema::table('brands', function (Blueprint $table) {
            if (!Schema::hasColumn('brands', 'is_active')) {
                $table->boolean('is_active')->default(true);
            }
        });
    }

    public function down(): void {
        Schema::table('kategoris', function (Blueprint $table) {
            if (Schema::hasColumn('kategoris', 'parent_id')) {
                $table->dropConstrainedForeignId('parent_id');
            }
            if (Schema::hasColumn('kategoris', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
        Schema::table('brands', function (Blueprint $table) {
            if (Schema::hasColumn('brands', 'is_active')) {
                $table->dropColumn('is_active');
            }
        });
    }
};
