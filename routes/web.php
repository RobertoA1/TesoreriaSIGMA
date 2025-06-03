<?php

use App\Http\Controllers\CursoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FamiliarController;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth'])->group(function(){
    Route::get('/', function(){
        if (Gate::allows('is-admin')){
            return view('administrativo-index');
        }

        return view('usuario-index');
    })->name('principal');
});

Route::group(['middleware' => ['auth', 'can:access-resource,"academica"']], function(){
    Route::get('/niveles-academicos', [NivelEducativoController::class, 'index'])->name('nivel_educativo_view');

    Route::get('/niveles-academicos/crear', [NivelEducativoController::class, 'create'])->name('nivel_educativo_create');
    Route::put('/niveles-academicos/crear', [NivelEducativoController::class, 'createNewEntry'])->name('nivel_educativo');

    Route::get('/niveles-academicos/{id}/editar', [NivelEducativoController::class, 'edit'])->name('nivel_educativo_edit');
    Route::patch('/niveles-academicos/{id}/editar', [NivelEducativoController::class, 'editEntry']);

    Route::delete('/niveles-academicos/', [NivelEducativoController::class, 'delete']);

    Route::get('/cursos', [CursoController::class, 'index'])->name('curso_view');

    Route::get('/cursos/crear', [CursoController::class, 'create'])->name('curso_create');
    Route::put('/cursos/crear', [CursoController::class, 'createNewEntry'])->name('curso');

    Route::get('/cursos/{id}/editar', [CursoController::class, 'edit'])->name('curso_edit');
    Route::patch('/cursos/{id}/editar', [CursoController::class, 'editEntry']);

    Route::delete('/cursos', [CursoController::class, 'delete']);

});



Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'iniciarSesion']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');