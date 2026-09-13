<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangIn extends Model
{

    use HasFactory;

    protected $table = 'barang_masuks'; // nama tabel di database

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id', 'Id_Barang');
    }

    protected $primaryKey = 'id';        // sesuaikan jika primary key berbeda
    public $timestamps = true;          // matikan kalau tabel tidak punya created_at & updated_at

    protected $fillable = [
        'nama_barang',
        'jumlah',
        'tanggal_masuk',

    ];
}
