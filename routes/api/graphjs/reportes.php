<?php

use App\Http\Controllers\Reportes\ReportesAcademicosController;

Route::get('/alumnosMatriculados', [ReportesAcademicosController::class,'alumnosMatriculados'])
    ->name('alumnosMatriculados');

Route::get('/alumnosNuevosVsAntiguos', [ReportesAcademicosController::class,'alumnosNuevosVsAntiguos'])
    ->name('alumnosNuevosVsAntiguos');

Route::get('/alumnosPorGenero', [ReportesAcademicosController::class,'alumnosPorGenero'])
    ->name('alumnosPorGenero');

Route::get('/alumnosRetirados', [ReportesAcademicosController::class,'alumnosRetirados'])
    ->name('alumnosRetirados');

Route::get('/alumnosPorGradoDeEdad', [ReportesAcademicosController::class,'alumnosPorGradoDeEdad'])
    ->name('alumnosPorGradoDeEdad');