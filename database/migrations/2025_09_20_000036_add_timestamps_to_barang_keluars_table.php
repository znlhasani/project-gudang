<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barang_keluars', function (Blueprint $table) {
            // tambahkan created_at & updated_at hanya kalau belum ada
            if (!Schema::hasColumn('barang_keluars', 'created_at') &&
                !Schema::hasColumn('barang_keluars', 'updated_at')) {
                $table->timestamps(); 
            }
        });
    }

    public function down(): void
    {
        Schema::table('barang_keluars', function (Blueprint $table) {
            if (Schema::hasColumn('barang_keluars', 'created_at')) {
                $table->dropColumn('created_at');
            }
            if (Schema::hasColumn('barang_keluars', 'updated_at')) {
                $table->dropColumn('updated_at');
            }
        });
    }
};
