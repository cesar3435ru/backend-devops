<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgrController;
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
        Route::post('logout', 'logout');
        Route::get('profilead', 'userProfileInfo');
        Route::put('updateinfo', 'updateUser');
        Route::post('refresh', 'refresh');
    });
    Route::post('addadmin', [UserController::class, 'addAdmin']);
    Route::post('addagr', [UserController::class, 'addAgremiado']);
    Route::get('admins', [UserController::class, 'getAdmins']);
    Route::get('agremiados', [UserController::class, 'getAgremiados']);
    Route::get('u/{id}', [UserController::class, 'getUserById']);
    Route::put('user/{id}', [UserController::class, 'editUser']);
    Route::delete('borraru/{id}', [UserController::class, 'deleteUser']);

    Route::post('addagremiado', [AgrController::class, 'addAgremiado']);
    Route::get('agrs', [AgrController::class, 'getAgremiados']);
    Route::put('agremiado/{id}', [AgrController::class, 'editAgremiado']);
    Route::delete('bagremiado/{id}', [AgrController::class, 'deleteAgremiado']);


});

Route::middleware(['onlyagremiado'])->group(function () {
    // Define aquí las rutas que solo deben ser accesibles por administradores
    // Route::post('profile', [AuthController::class, 'userProfileInfo']);
    Route::controller(AuthController::class)->group(function () {
        Route::post('logoutt', 'logout');
        Route::get('profile', 'userProfileInfo');
        Route::put('updateinfoo', 'updateUser');
        Route::post('refreshh', 'refresh');
    });

});


//Rutas publicas
Route::post('login', [AuthController::class, 'login']);
Route::post('radmin', [UserController::class, 'addAdmin']);
Route::post('ragre', [UserController::class, 'addAgre']);
