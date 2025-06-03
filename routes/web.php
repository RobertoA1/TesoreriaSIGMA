<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\FamiliarController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function(){
    Route::get('/', function(){
        return view('index');
    })->name('principal');
});

Route::group(['middleware' => ['auth', 'can:access-resource,"academica"']], function(){
    Route::get('/niveles-academicos', function(){
        return view('gestiones.nivel_educativo.index');
    })->name('nivel_educativo_view');
});

Route::group(['middleware' => ['auth', 'can:access-resource,"alumnos"']], function(){
    Route::get('/familiares', function(){
        return view('gestiones.familiar.index');
    })->name('familiar_view');

    Route::get('/familiares/{idFamiliar}', [FamiliarController::class, 'show'])->name('familiares.show');
});

Route::group(['middleware' => ['auth', 'can:access-resource,"financiera"']], function(){
    Route::get('/pagos', function(){
        return view('gestiones.pago.index');
    })->name('pago_view');
    
    Route::get('/conceptos_pago', function(){
        return view('gestiones.conceptoPago.index');
    })->name('concepto_pago_view');

});

Route::group(['middleware' => ['auth', 'can:access-resource,"administrativa"']], function(){
    Route::get('/conceptos_accion', function(){
        return view('gestiones.conceptoAccion.index');
    })->name('concepto_accion_view');
});



Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'iniciarSesion']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');