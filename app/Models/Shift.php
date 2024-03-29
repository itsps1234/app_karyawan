<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shift extends Model
{
    use HasFactory;
    public $incrementing = false;
    protected $guarded = ['id'];

    public function MappingShift()
    {
        return $this->hasMany(MappingShift::class);
    }
}
