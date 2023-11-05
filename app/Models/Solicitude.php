<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitude extends Model
{
    use HasFactory;
    protected $fillable = ['nue', 'ruta_archivo'];


   
    public function user()
    {
        return $this->belongsTo(User::class, 'nue');
    }
    
}
