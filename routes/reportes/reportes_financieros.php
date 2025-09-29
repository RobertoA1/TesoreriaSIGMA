<?php

use App\Http\Controllers\ReporteFinancieroController;

Route::get('/', [ReporteFinancieroController::class, 'index'])
    ->name('view');