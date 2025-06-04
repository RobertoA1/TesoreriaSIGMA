<?php

use App\Http\Controllers\LoginController;

Route::middleware(['auth'])->group(function(){
    Route::get('/', function(){
        if (Gate::allows('is-admin')){
            return view('administrativo-index');
        }

        return view('usuario-index');
    })->name('principal');
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'iniciarSesion']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');