<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['onlyadmin'])->group(function () {
    // Define aquí las rutas que solo deben ser accesibles por administradores
    Route::controller(AuthController::class)->group(function () {
        Route::post('login', 'login');
        Route::post('logout', 'logout');
        Route::get('profile', 'userProfileInfo');
        Route::put('updateinfo', 'updateUser');
        Route::post('refresh', 'refresh');
        Route::get('users', 'getUsers');
    });
});

Route::middleware(['jwt.auth', 'onlyagremiado'])->group(function () {
    // Define aquí las rutas que solo deben ser accesibles por administradores
});


//Rutas publicas
Route::post('register', [AuthController::class, 'registerUser']);
Route::post('login', [AuthController::class, 'login']);
