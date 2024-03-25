<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Izin extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $guarded = ['id'];

    protected $fillable = [
        'user_id',
        'departements_id',
        'jabatan_id',
        'divisi_id',
        'telp',
        'email',
        'fullname',
        'izin',
        'tanggal',
        'jam',
        'keterangan_izin',
        'foto_izin',
        'approve_atasan',
        'id_approve_atasan',
        'status_izin',
        'catatan',
    ];


}
