<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('m_stock', function (Blueprint $table) {
            $table->id('stock_id');
            $table->unsignedBigInteger('barang_id');
            $table->unsignedBigInteger('user_id');
            $table->dateTime('stock_tanggal');
            $table->integer('stock_jumlah');
            $table->timestamps();

            $table->foreign('barang_id')->references('barang_id')->on('m_barang');
            $table->foreign('user_id')->references('user_id')->on('m_user');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('m_stock');
    }
};
