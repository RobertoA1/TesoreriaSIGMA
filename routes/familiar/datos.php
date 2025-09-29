<?php

use App\Http\Controllers\FamiliarDatosController;

Route::get('/', [FamiliarDatosController::class, 'index'])
    ->name('view');

Route::get('/editar', [FamiliarDatosController::class, 'edit'])
->name('edit');

Route::patch('/editar', [FamiliarDatosController::class, 'editEntry'])
->name('editEntry');