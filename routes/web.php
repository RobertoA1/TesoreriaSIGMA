<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\NivelEducativoController;
use App\Http\Controllers\FamiliarController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function(){
    Route::get('/', function(){
        return view('index');
    })->name('principal');
});

Route::group(['middleware' => ['auth', 'can:access-resource,"academica"']], function(){
    Route::get('/niveles-academicos', [NivelEducativoController::class, 'index'])->name('nivel_educativo_view');

    Route::get('/niveles-academicos/crear', [NivelEducativoController::class, 'create'])->name('nivel_educativo_create');

    Route::get('/niveles-academicos/editar', [NivelEducativoController::class, 'create'])->name('nivel_educativo_edit');

    Route::get('/niveles-academicos/eliminar', [NivelEducativoController::class, 'create'])->name('nivel_educativo_delete');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'iniciarSesion']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');