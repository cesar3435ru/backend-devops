<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuota extends Model
{
    use HasFactory;
    protected $fillable = ['id','respuesta'];


    public function agremiado()
    {
        return $this->belongsTo(Agremiado::class);
    }

}
