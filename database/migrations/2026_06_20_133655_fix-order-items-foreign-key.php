<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('order_items', function (Blueprint $table) {
            // Hapus foreign key lama yang mengarah ke tabel 'orders'
            $table->dropForeign(['order_id']);
            
            // Buat foreign key baru yang mengarah ke tabel 'pesanans'
            $table->foreign('order_id')->references('id')->on('pesanans')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['order_id']);
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
        });
    }
};