<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangOut extends Model
{


    use Hasfactory;

    public function barang()
    {
        return $this->belongsTo(Barang::class, 'barang_id');
    }


    protected $table = 'barang_keluars'; // nama tabel di database
    protected $primaryKey = 'id';        // sesuaikan jika primary key berbeda
    public $timestamps = true;          // matikan kalau tabel tidak punya created_at & updated_at

    protected $fillable = [
        'barang_id',
        'nama_barang',
        'jumlah',
        'tanggal_keluar',

    ];
}
