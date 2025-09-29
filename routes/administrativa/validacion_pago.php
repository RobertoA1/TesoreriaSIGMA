<?php

use App\Http\Controllers\ValidacionPagoController;

Route::get('/', [ValidacionPagoController::class, 'index'])
        ->name('view');