<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/auth/routes.php';

Route::middleware(['auth'])->group(function(){
    require __DIR__ . '/academica/routes.php';
    require __DIR__ . '/alumnos/routes.php';
    require __DIR__ . '/administrativa/routes.php';
    require __DIR__ . '/financiera/routes.php';
    require __DIR__ . '/personal/routes.php';
    require __DIR__ . '/reportes/routes.php';

    Route::get('/tests', [\App\Http\Controllers\Tests\CRUDTestController::class, 'index']);
});