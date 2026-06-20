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
        Schema::table('orders', function (Blueprint $table) {
            $table->enum('status_bayar', ['Lunas', 'Belum Lunas'])->default('Lunas')->after('metode_bayar');
            $table->date('tanggal_bayar')->nullable()->after('status_bayar');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['status_bayar', 'tanggal_bayar']);
        });
    }
};
