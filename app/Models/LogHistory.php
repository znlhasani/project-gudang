<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Tambahkan ini

class LogHistory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'log_histories'; // sekarang cocok dengan migration
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'aksi',
        'nama_barang',
        'jumlah',
        'stok_sekarang',
        'kondisi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}


