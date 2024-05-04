<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuti extends Model
{
    use HasFactory, UuidTrait;
    protected $guarded = ['id'];
    public $incrementing = false;
    protected $fillable = [
        'user_id',
        'kategori_cuti_id',
        'nama_cuti',
        'tanggal',
        'tanggal_mulai',
        'tanggal_selesai',
        'total_cuti',
        'keterangan_cuti',
        'foto_cuti',
        'status_cuti',
        'user_id_backup',
        'ttd_user',
        'waktu_ttd_user',
        'approve_atasan',
        'approve_atasan2',
        'id_user_atasan',
        'id_user_atasan2',
        'ttd_atasan',
        'ttd_atasan2',
        'waktu_approve',
        'waktu_approve2',
        'catatan',
        'catatan2',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
