<?php

namespace App\Http\Controllers;

use App\Models\Agremiado;
use App\Models\Cuota;
use App\Models\Genero;
use App\Models\User;

class GeneroController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function getGeneros()
    {
        $generos = Genero::all();
        return response()->json([
            'generos' => $generos
        ], 200);
    }

    public function getAgremiadosNues()
    {
        $users = User::where('rol_id', 2)->get();
        return response()->json($users, 200);
    }

    public function getCuotas()
    {
        $cuotas = Cuota::all();
        return response()->json($cuotas, 200);
    }
}
