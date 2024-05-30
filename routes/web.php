<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnexoController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\ArchivosAnexoController;
use App\Http\Controllers\ArchivosDicController;
use App\Http\Controllers\EstacionesAnexoController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\OperacionController;
use App\Http\Controllers\PagosAnexoController;
use App\Http\Controllers\ServicioAnexoController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TramitesEmaController;
use Illuminate\Support\Facades\Auth;


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
    Route::post('/pdf_cotizacion', [ServicioAnexoController::class, 'generarpdfcotizacion'])->name('pdf.cotizacion');
    Route::view('/', 'home')->name('home');
    Route::resource('roles', RolController::class);
    Route::resource('usuarios', UsuarioController::class);
    Route::resource('operacion', OperacionController::class);
    Route::resource('archivos', ArchivosDicController::class);
    Route::resource('notificaciones', ApprovalController::class);
    Route::resource('anexo', AnexoController::class);
    Route::resource('servicio_anexo', ServicioAnexoController::class);
    Route::resource('pago_anexo', PagosAnexoController::class);
    Route::resource('estacion_anexo', EstacionesAnexoController::class);
    Route::resource('ema', TramitesEmaController::class);
    Route::resource('archivos_anexo', ArchivosAnexoController::class);
    Route::get('/obtener-servicios', [ServicioAnexoController::class, 'obtenerServicios'])->name('servicio_anexo.obtenerServicios');

    Route::get('/apro_anexo', [ServicioAnexoController::class, 'AproAnexo'])->name('apro.anexo');





    Route::get('/fetch-notifications', [NotificationController::class, 'fetchNotifications']);

    // Rutas para las notificaciones
    Route::get('/approval/{id}', [ApprovalController::class, 'show'])->name('approval.show');
    Route::post('/approval/{id}/approve', [ApprovalController::class, 'approveDeletion'])->name('approval.approve');
    Route::post('/approval/{id}/cancel', [ApprovalController::class, 'cancelDeletion'])->name('approval.cancel');

    //ruta cambio de contraseña
    Route::get('/usuarios/{id}/cambiar-contrasena', [UsuarioController::class, 'showChangePasswordForm'])->name('usuarios.showchangepasswordform');

    Route::post('/usuarios/{id}/cambiar-contrasena', [UsuarioController::class, 'updatePassword'])->name('usuarios.cambiar-contrasena');
});
