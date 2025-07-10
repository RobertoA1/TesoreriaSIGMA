<?php

use Illuminate\Http\Request;

use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\LoginController;

Route::middleware(['auth'])->group(function(){
    Route::get('/', function(Request $request){
        if (Gate::allows('is-admin')){
            return view('administrativo-index');
        }

        return HomeController::index($request);
    })->name('principal');

    Route::post('/', [HomeController::class, 'definirSesion']);
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'iniciarSesion']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');