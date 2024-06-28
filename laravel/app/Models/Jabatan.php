<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Jabatan extends Model
{
    use HasFactory, UuidTrait;
    public $incrementing = false;
    protected $guarded = ['id', 'created_at', 'updated_at'];
    protected $fillable = ['divisi_id', 'atasan_id', 'atasan2_id', 'bagian_id', 'nama_jabatan', 'level_id', 'created_at', 'updated_at'];

    public function LevelJabatan(): BelongsTo
    {
        return $this->belongsTo(LevelJabatan::class, 'level_id', 'id');
    }
    public function Bagian(): BelongsTo
    {
        return $this->belongsTo(Bagian::class, 'bagian_id', 'id');
    }
    public function Divisi(): BelongsTo
    {
        return $this->belongsTo(Divisi::class, 'divisi_id', 'id');
    }
}
