<?php

use App\Http\Controllers\PagoController;

Route::get('/', [PagoController::class, 'index'])
    ->name('view');

Route::group(['middleware' => ['can:manage-resource,"financiera","create"']], function(){
    Route::get('/crear', [PagoController::class, 'create'])
        ->name('create');

    Route::put('/crear', [PagoController::class, 'createNewEntry'])
        ->name('createNewEntry');

    Route::get('/buscarAlumno/{codigo}', [PagoController::class,'buscarAlumno'])->name('buscarAlumno');
});

Route::group(['middleware' => ['can:manage-resource,"financiera","edit"']], function(){
    Route::get('/{id}/editar', [PagoController::class, 'edit'])
        ->name('edit');

    Route::patch('/{id}/editar', [PagoController::class, 'editEntry'])
        ->name('editEntry');
});

Route::group(['middleware' => ['can:manage-resource,"financiera","delete"']], function(){
    Route::delete('/', [PagoController::class, 'delete'])
        ->name('delete');
});

Route::group(['middleware' => ['can:manage-resource,"financiera","view_details"']], function(){
    Route::get('/{id}/detalles', [PagoController::class, 'viewDetalles'])
        ->name('detalles');
});
