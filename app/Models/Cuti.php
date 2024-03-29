<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public $incrementing = false;
    protected $fillable = [
        'user_id',
        'nama_cuti',
        'tanggal',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_cuti',
        'keterangan_cuti',
        'foto_cuti',
        'status_cuti',
        'approve_atasan',
        'id_user_atasan',
        'ttd_atasan',
        'waktu_approve',
        'catatan',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
