<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('barang_masuks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('barang_id')->constrained('barangs')->onDelete('cascade');
            $table->string('nama_barang');
            $table->integer('jumlah');
            $table->timestamps(); // ✅ otomatis buat created_at & updated_at
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('barang_masuks');
    }
};
