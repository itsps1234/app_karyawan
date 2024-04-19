<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departemen extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $guarded = ['id'];
    protected $fillable = ['id', 'nama_departemen', 'created_at', 'updated_at'];

    public function Jabatan()
    {
        return $this->hasMany(Jabatan::class);
    }
}
