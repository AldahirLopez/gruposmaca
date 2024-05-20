<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnexoController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ArchivosDicController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\OperacionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/



Auth::routes();

Route::group(['middleware' => ['auth']], function () {
    Route::view('/', 'home')->name('home');
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('operacion', OperacionController::class);
    Route::resource('archivos', ArchivosDicController::class);
    Route::resource('notificaciones', ApprovalController::class);
    Route::resource('anexo', AnexoController::class);


    // Rutas para las notificaciones
    Route::get('/approval/{id}', [ApprovalController::class, 'show'])->name('approval.show');
    Route::post('/approval/{id}/approve', [ApprovalController::class, 'approveDeletion'])->name('approval.approve');
    Route::post('/approval/{id}/cancel', [ApprovalController::class, 'cancelDeletion'])->name('approval.cancel');

    //ruta cambio de contraseña
    Route::get('/usuarios/{id}/cambiar-contrasena', [UsuarioController::class, 'showChangePasswordForm'])->name('usuarios.showchangepasswordform');

    Route::post('/usuarios/{id}/cambiar-contrasena', [UsuarioController::class, 'updatePassword'])->name('usuarios.cambiar-contrasena');
});
