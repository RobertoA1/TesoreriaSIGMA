<?php

use App\Http\Controllers\AlumnoController;

Route::get('/', [AlumnoController::class, 'index'])
    ->name('view');

Route::group(['middleware' => ['can:manage-resource,"alumnos","create"']], function(){
    Route::get('/crear', [AlumnoController::class, 'create'])
        ->name('create');

    Route::put('/crear', [AlumnoController::class, 'createNewEntry'])
        ->name('createNewEntry');
});

Route::group(['middleware' => ['can:manage-resource,"alumnos","edit"']], function(){
    Route::get('/{id}/editar', [AlumnoController::class, 'edit'])
        ->name('edit');

    Route::patch('/{id}/editar', [AlumnoController::class, 'editEntry'])
        ->name('editEntry');
});

Route::group(['middleware' => ['can:manage-resource,"alumnos","delete"']], function(){
    Route::delete('/', [AlumnoController::class, 'delete'])
        ->name('delete');
});
