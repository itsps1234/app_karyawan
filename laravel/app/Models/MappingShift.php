<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MappingShift extends Model
{
    use HasFactory, UuidTrait;
    protected $guarded = ['id'];
    public $incrementing = true;
    protected $fillable = [
        'user_id',
        'shift_id',
        'tanggal',
        'jam_absen',
        'telat',
        'lat_absen',
        'long_absen',
        'jarak_masuk',
        'foto_jam_absen',
        'jam_pulang',
        'pulang_cepat',
        'lembur',
        'foto_jam_pulang',
        'lat_pulang',
        'long_pulang',
        'jarak_pulang',
        'status_absen',
        'keterangan_absensi'
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function Shift()
    {
        return $this->belongsTo(Shift::class);
    }
}
