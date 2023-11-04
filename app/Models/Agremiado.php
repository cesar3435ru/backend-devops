<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agremiado extends Model
{
    use HasFactory;
    protected $fillable = ['id', 'a_paterno', 'a_materno', 'nombre', 'genero', 'nup', 'nue', 'rfc', 'nss', 'f_nacimiento', 'telefono', 'cuota'];
    public function user()
    {
        return $this->belongsTo(User::class,'nue');
    }

    //Relacion de uno a muchos----un agremiado puede agregar muchas solicitudes
    public function addSolicitud()
    {
        return $this->hasMany(Solicitude::class);
    }

    public function genero()
    {
        return $this->belongsTo(Genero::class, 'genero');
    }

    public function cuota()
    {
        return $this->belongsTo(Cuota::class, 'cuota'); // Asegúrate de usar el nombre correcto de la columna de la clave foránea
    }
}
