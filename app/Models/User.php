<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Str;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, UuidTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    public $incrementing = false;
    protected $guarded = ['id',];
    protected $fillable = [
        'name',
        'fullname',
        'motto',
        'foto_karyawan',
        'email',
        'telepon',
        'username',
        'password',
        'tgl_lahir',
        'gender',
        'tgl_join',
        'status_nikah',
        'alamat',
        'cuti_dadakan',
        'cuti_bersama',
        'cuti_menikah',
        'cuti_diluar_tanggungan',
        'cuti_khusus',
        'cuti_melahirkan',
        'izin_telat',
        'izin_pulang_cepat',
        'is_admin',
        'dept_id',
        'divisi_id',
        'jabatan_id'
    ];


    public function MappingShift()
    {
        return $this->hasMany(MappingShift::class);
    }

    public function Sip()
    {
        return $this->hasMany(Sip::class);
    }

    public function Lembur()
    {
        return $this->hasMany(Lembur::class);
    }

    public function Cuti()
    {
        return $this->hasMany(Cuti::class);
    }

    public function Jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    // public static function boot()
    // {
    //     parent::boot();

    //     static::creating(function ($model) {
    //         $model->id = Str::uuid();
    //         $model->jabatan_id = Jabatan::where('id', $model->id)->value('id');
    //     });
    // }
}
