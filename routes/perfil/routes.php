<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;

Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [ProfileController::class, 'index'])->name('perfil.view');
    Route::get('/perfil/editar', [ProfileController::class, 'edit'])->name('perfil.edit');
    Route::patch('/perfil/editar', [ProfileController::class, 'editEntry'])->name('perfil.editEntry');
    Route::get('/perfil/cambiar-password', [ProfileController::class, 'showPasswordForm'])->name('perfil.password.form');
    Route::patch('/perfil/password', [ProfileController::class, 'updatePassword'])->name('perfil.password.update');
    Route::post('/perfil/editar', [App\Http\Controllers\Home\HomeController::class, 'definirSesion']);
});
