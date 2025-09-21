<?php

use App\Http\Controllers\DepartamentoAcademicoController;

Route::get('/', [DepartamentoAcademicoController::class, 'index'])
    ->name('view');