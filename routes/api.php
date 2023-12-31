<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AgrController;
use App\Http\Controllers\SolicitudController;
use App\Http\Controllers\IsAuthenticatedController;
use App\Http\Controllers\GeneroController;
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
    Route::post('addagr', [UserController::class, 'addAgre']);
    Route::get('admins', [UserController::class, 'getAdmins']);
    Route::get('agremiados', [UserController::class, 'getAgremiados']);
    Route::get('u/{id}', [UserController::class, 'getUserById']);
    Route::put('user/{id}', [UserController::class, 'editUser']);
    Route::put('agr/{id}', [UserController::class, 'editUser']);
    Route::delete('borraru/{id}', [UserController::class, 'deleteUser']);
    Route::delete('borraragr/{id}', [UserController::class, 'deleteUser']);

    Route::post('addagremiado', [AgrController::class, 'addAgremiado']);
    Route::get('agrs', [AgrController::class, 'getAgremiados']);
    Route::put('agremiado/{id}', [AgrController::class, 'editAgremiado']);
    Route::get('getagremiado/{id}', [AgrController::class, 'getAgremiadoById']);
    Route::delete('bagremiado/{id}', [AgrController::class, 'deleteAgremiado']);

    Route::get('solis', [SolicitudController::class, 'getSolis']);
    Route::get('download/{id}', [SolicitudController::class, 'downloadFile'])->name('file.download');

    Route::get('solisporfecha', [SolicitudController::class, 'getSolisByFecha']);

    Route::get('generos', [GeneroController::class, 'getGeneros']);
    Route::get('nues', [GeneroController::class, 'getAgremiadosNues']);
    Route::get('cuotas', [GeneroController::class, 'getCuotas']);


});

Route::middleware(['onlyagremiado'])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('logoutt', 'logout');
        Route::get('profileagr', 'userProfileInfo');
        Route::put('updateinfoo', 'updateUser');
        Route::post('refreshh', 'refresh');
    });

    Route::post('rsolicitud', [SolicitudController::class, 'addSoli']);
    Route::get('solicitudes', [SolicitudController::class, 'getAllSolisByUser']);
    Route::delete('soli/{id}', [SolicitudController::class, 'deleteSoliById']);
});


//Rutas publicas
Route::post('login', [AuthController::class, 'login']);
Route::post('loginagr', [AuthController::class, 'login']);
Route::get('status', [IsAuthenticatedController::class, 'checkAuthentication']);
// Route::post('radmin', [UserController::class, 'addAdmin']);
// Route::post('ragre', [UserController::class, 'addAgre']);
