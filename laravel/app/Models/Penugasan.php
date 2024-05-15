<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penugasan extends Model
{
    use HasFactory, UuidTrait;
    protected $guarded = ['id'];
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = [
        'id_user',
        'id_user_atasan',
        'id_user_atasan2',
        'id_jabatan',
        'id_departemen',
        'id_divisi',
        'asal_kerja',
        'id_diajukan_oleh',
        'ttd_id_diajukan_oleh',
        'waktu_ttd_id_diajukan_oleh',
        'id_diminta_oleh',
        'ttd_id_diminta_oleh',
        'waktu_ttd_id_diminta_oleh',
        'id_disahkan_oleh',
        'ttd_id_disahkan_oleh',
        'waktu_ttd_id_disahkan_oleh',
        'id_user_hrd',
        'ttd_proses_hrd',
        'waktu_ttd_proses_hrd',
        'id_user_finance',
        'ttd_proses_finance',
        'waktu_ttd_proses_finance',
        'penugasan',
        'wilayah_penugasan',
        'tanggal_kunjungan',
        'selesai_kunjungan',
        'kegiatan_penugasan',
        'pic_dikunjungi',
        'alamat_dikunjungi',
        'transportasi',
        'kelas',
        'budget_hotel',
        'makan',
        'status_penugasan',
        'tanggal_pengajuan',
        'ttd_userpenugasan',
    ];

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
