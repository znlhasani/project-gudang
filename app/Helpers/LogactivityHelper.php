<?php

namespace App\Helpers;

use App\Models\LogHistory;
use Illuminate\Support\Facades\Auth;

class LogActivityHelper
{
    public static function add($aksi, $nama_barang, $jumlah = 0, $stok_sekarang = 0, $kondisi = 'Normal')
    {
        LogHistory::create([
            'user_id' => Auth::check() ? Auth::id() : null,
            'aksi' => $aksi,
            'nama_barang' => $nama_barang,
            'jumlah' => $jumlah,
            'stok_sekarang' => $stok_sekarang,
            'kondisi' => $kondisi,
            'waktu' => now(),
        ]);
    }
}
