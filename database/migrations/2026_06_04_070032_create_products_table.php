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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); //nama produk
            $table->string('kategori'); //kategori: spanduk stiker dll
            $table->integer('harga_dasar'); //harga dasar per meter/perlembar
            $table->string('image')->nullable(); //foto produk cetakan
            $table->string('ukuran_standar')->nullable(); //Menyimpan standar lebar mesin (misal: 1, 1,5 , 2, 3) dalam format string/json
            $table ->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
