<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\HomeController; // Ya está importado, ¡genial!
use Illuminate\Support\Facades\Route; // Asegúrate de que esta línea esté presente
use Illuminate\Support\Facades\Gate; // Asegúrate de que esta línea esté presente si usas Gate

Route::middleware(['auth'])->group(function(){
    // Modificamos esta ruta
    Route::get('/', function(){
        if (Gate::allows('is-admin')){
            // Si es admin, redirigimos a una ruta que maneja el HomeController
            return redirect()->route('admin.dashboard');
        }

        // Si no es admin (pero está autenticado), va a la vista de usuario
        return view('usuario-index');
    })->name('principal');

    // **NUEVA RUTA PARA EL ADMINISTRADOR**
    // Esta ruta será la que cargue el dashboard del administrador
    Route::get('/admin/dashboard', [HomeController::class, 'index'])
        ->middleware('can:is-admin') // Opcional: Puedes añadir el middleware 'can' aquí también para mayor seguridad
        ->name('admin.dashboard');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'iniciarSesion']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');