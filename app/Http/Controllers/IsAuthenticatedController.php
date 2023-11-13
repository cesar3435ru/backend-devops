<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;

class IsAuthenticatedController extends Controller
{
    // public function checkAuthentication(Request $request)
    // {
    //     try {
    //         // Intenta autenticar al usuario a partir de la cookie JWT
    //         $user = JWTAuth::parseToken()->authenticate();
    
    //         if ($user) {
    //             $message = 'Bienvenido, ' . $user->name; // Agrega el mensaje de bienvenida
    //             return response()->json(['authenticated' => true, 'message' => $message]);
    //         } else {
    //             return response()->json(['authenticated' => false, 'message' => 'Usuario no autenticado']);
    //         }
    //     } catch (\Exception $e) {
    //         // Captura cualquier excepción y devuelve false
    //         return response()->json(['authenticated' => false, 'message' => 'Error al autenticar']);
    //     }
    // }
    

    public function checkAuthentication(Request $request)
    {
        try {
            // Intenta autenticar al usuario a partir de la cookie JWT
            $user = JWTAuth::parseToken()->authenticate();

            if ($user) {
                return response()->json(true);
            } else {
                return response()->json(['error' => 'User not found'], 401);
            }
        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {
            return response()->json(['error' => 'Token has expired'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {
            return response()->json(['error' => 'Invalid token'], 401);
        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {
            return response()->json(['error' => 'The token could not be parsed from the request'], 401);
        } catch (\Exception $e) {
            // Captura cualquier excepción y devuelve false
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
