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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Menghubungkan pesanan dengan user yang login dan produk yang dipilih
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            
            // Kolom dinamis (bisa bernilai NULL tergantung jenis produk)
            $table->float('panjang')->nullable();
            $table->float('lebar')->nullable();
            $table->integer('quantity')->nullable();
            
            // Detail file desain, catatan tambahan, dan harga final setelah pembulatan
            $table->string('file_desain')->nullable();;
            $table->text('catatan')->nullable();
            $table->integer('total_harga');
            
            // Status pelacakan pesanan (Alur standar operasional cetak)
            $table->enum('status', ['Pending', 'Diproses', 'Selesai Cetak', 'Bisa Diambil'])->default('Pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};