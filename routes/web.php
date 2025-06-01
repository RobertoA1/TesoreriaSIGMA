<?php

use App\Http\Controllers\LoginController;
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

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'iniciarSesion']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');