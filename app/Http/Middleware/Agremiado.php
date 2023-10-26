<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Agremiado
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // switch(Auth::user()->rol_id){
        //     case 1:
        //         return $next($request);//si es administrador manda a su interfaz y sus funciones
        //     break;
        // 	case 2:
        //         return redirect('comite');// Si es agremiado manda su interaz y funciones
        //     break;
        // }
        if (auth('api')->user()) {
            $rol_id = auth('api')->user()->rol_id;

            if ($rol_id === 2) { //compara que ambos datos sean de un mismo tipo es decir, 1 tipo int === a 1 tipo int, en cambio 1 tipo string == a 1 tipo string
                return $next($request); // Si es administrador, permite continuar al HOME.
            } elseif ($rol_id === 1) {
                return redirect('administrador'); // Si es comité, redirige al agremiado.
            } else {
                return response(['message' => 'This role does not exist in DB'], 401);
            }
        } else {
            return response(['message' => 'No authenticated'], 401);
        }
    }
}
