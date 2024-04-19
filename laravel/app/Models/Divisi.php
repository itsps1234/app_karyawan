<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Divisi extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $guarded = ['id', 'nama_divisi', 'created_at', 'updated_at'];


    public function Departemen()
    {
        return $this->belongsTo(Jabatan::class);
    }
}
