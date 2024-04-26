<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Izin extends Model
{
    use HasFactory, UuidTrait;
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
        'ttd_pengajuan',
        'waktu_ttd_pengajuan',
        'approve_atasan',
        'id_approve_atasan',
        'status_izin',
        'waktu_approve',
        'catatan',
    ];

    public function User(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id', 'user_id');
    }
}
