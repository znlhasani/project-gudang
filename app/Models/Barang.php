<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    use HasFactory;

    protected $table = 'Barang'; // ✅ sesuaikan dengan nama tabel di database

    protected $primaryKey = 'Id_Barang'; // ✅ sesuaikan dengan PK di tabel

    public $timestamps = true; // ✅ karena ada created_at & updated_at

    public function barangIn()
{
    return $this->hasMany(BarangIn::class, 'barang_id');
}

    // ✅ field yang bisa diisi
    protected $fillable = [
        'Kode_Barang',
        'nama_barang',
        'kategori',
        'stok',
    ];



}
