<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LevelJabatan extends Model
{
    use HasFactory;
    protected $guarded = ['id', 'level_jabatan', 'created_at', 'updated_at'];

    public function Jabatan()
    {
        return $this->hasMany(Jabatan::class);
    }
}
