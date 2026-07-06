<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanans', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('customer_name');
            $table->string('customer_phone')->nullable();
            $table->json('items');
            $table->bigInteger('total_price')->default(0);
            $table->enum('status', ['masuk','dikonfirmasi','dalam_perjalanan','dikemas','dikirim','selesai','dibatalkan'])->default('masuk');
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanans');
    }
};
