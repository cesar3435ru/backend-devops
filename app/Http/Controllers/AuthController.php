<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Cookie;

class AuthController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'users']]);
    }


    public function updateUser(Request $request)
    {
        if (!Auth::check()) {
            return response()->json(['error' => 'No access'], 401);
        }

        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'nue' => 'required|string|max:8',
            // 'email' => 'required|string|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8' // The password is optional
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $user->update([
            'nue' => $request->name,
            'id' => $user->id, // Assign the user id automatically
            'password' => $request->password ? bcrypt($request->password) : $user->password // Actualiza la contraseña solo si se proporciona
        ]);

        return response()->json(['user' => $user], 200);
    }


    public function login(Request $request)
    {
        $credentials = $request->only('nue', 'password');

        if (!JWTAuth::attempt($credentials)) {
            return response([
                'message' => 'Invalid credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = JWTAuth::user();
        $token = JWTAuth::fromUser($user);

        $expiration = now()->addHours(1); // La cookie expira en 2 horas
        $cookie = new Cookie('jwt', $token, $expiration, '/', null, false, true);

        return $this->respondWithToken($token, $user)->withCookie($cookie);
    }


    public function userProfileInfo()
    {
        return Auth::user();
    }

    //Decido usar esta funcion mejor
    public function logout()
    {
        return response([
            'message' => 'Successfully logged out!'
        ])->cookie('jwt', null, -1);
    }


    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token, $user)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => $user,
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
