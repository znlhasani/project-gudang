<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Tambahkan ini


class LogActivity extends Model
{

    use HasFactory, SoftDeletes;

    protected $table = 'log_activity'; // sesuai dengan tabel di SQL Server
    protected $primaryKey = 'Id_Activity'; // primary key sesuai tabel kamu
    public $timestamps = true; // karena ada created_at & updated_at

    protected $fillable = [
        'Aktivitas',
        'Detail',
        'Waktu',
        'user',
        'activity',
        'module',
        'ip',
        'time',
        'Id_User',
    ];

         public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
