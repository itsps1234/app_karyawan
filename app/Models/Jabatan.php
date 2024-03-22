<?php

namespace App\Models;

use App\Traits\UuidTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jabatan extends Model
{
    use HasFactory, UuidTrait;
    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function User()
    {
        return $this->hasMany(User::class);
    }
    public function levelJabatan()
    {
        return $this->belongsTo(levelJabatan::class, 'level_id', 'id');
    }
}
