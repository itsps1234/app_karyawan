<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $guarded = ['id', 'nama_departemen', 'created_at', 'updated_at'];

    public function Jabatan()
    {
        return $this->hasMany(Jabatan::class);
    }
    public function Divisi()
    {
        return $this->hasMany(Divisi::class);
    }
}
