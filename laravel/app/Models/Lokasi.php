<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $fillable = ['lokasi_kantor', 'lat_kantor', 'long_kantor', 'radius'];
}
