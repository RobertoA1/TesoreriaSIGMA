<?php

use App\Http\Controllers\LoginController;
use App\Http\Controllers\NivelEducativoController;
use App\Http\Controllers\FamiliarController;
use App\Http\Controllers\AlumnoController;
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
});

Route::group(['middleware' => ['auth', 'can:access-resource,"alumnos"']], function(){
    Route::get('/alumnos', [AlumnoController::class, 'index'])->name('alumno_view');

    Route::get('/alumnos/crear', [AlumnoController::class, 'create'])->name('alumno_create');
    Route::put('/alumnos/crear', [AlumnoController::class, 'createNewEntry'])->name('alumno');

    Route::get('/alumnos/{id}/editar', [AlumnoController::class, 'edit'])->name('alumno_edit');
    Route::patch('/alumnos/{id}/editar', [AlumnoController::class, 'editEntry']);

    Route::delete('/alumnos/', [AlumnoController::class, 'delete']);
});

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'iniciarSesion']);

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');