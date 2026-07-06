<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('invoice')->unique();
            $table->string('customer_name');
            $table->string('customer_phone')->nullable();
            $table->text('shipping_address')->nullable();
            $table->integer('total')->default(0);
            $string('payment_method', 50)->default('transfer');
            $string('status', 30)->default('masuk');
            $text('notes')->nullable();
            $timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
