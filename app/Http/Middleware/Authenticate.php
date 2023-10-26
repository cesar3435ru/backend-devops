<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Closure;
use Illuminate\Auth\AuthenticationException;



class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return null;
    }
    //Con esta funcion no es necesario poner el token para que me devuelva la informacion del usuario
    public function handle($request, Closure $next, ...$guards)
    {
        if ($jwt = $request->cookie('jwt')) {
            $request->headers->set('Authorization', 'Bearer ' . $jwt);
        }

        try {
            $this->authenticate($request, $guards);
        } catch (AuthenticationException $e) {
            return response(['message' => 'No authenticated babe'], 401);
        }

        return $next($request);
    }
}
