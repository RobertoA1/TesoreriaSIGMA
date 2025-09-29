<?php

use App\Http\Controllers\Reportes\ReportesAcademicosController;

Route::get('/', [ReportesAcademicosController::class, 'index'])
    ->name('view');