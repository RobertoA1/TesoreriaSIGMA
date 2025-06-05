<?php

namespace Database\Seeders;

use App\Models\Administrativo;
use App\Models\Curso_Grado;
use App\Models\User;
use App\Models\Alumno;
use App\Models\Catedra;
use App\Models\ComposicionFamiliar;
use App\Models\ConceptoAccion;
use App\Models\ConceptoPago;
use App\Models\Curso;
use App\Models\DepartamentoAcademico;
use App\Models\DetallePago;
use App\Models\Deuda;
use App\Models\Familiar;
use App\Models\Grado;
use App\Models\Matricula;
use App\Models\NivelEducativo;
use App\Models\Pago;
use App\Models\Personal;
use App\Models\RegistroHistorico;
use App\Models\Seccion;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(5)->create();
        Administrativo::factory(5)->create();
        Alumno::factory(5)->create();
        ComposicionFamiliar::factory(5)->create();

        ConceptoAccion::create(
            [
                'accion' => 'VER',
            ]);

        ConceptoAccion::create(
            [
                'accion' => 'CREAR',
            ]);
        
        ConceptoAccion::create(
            [
                'accion' => 'EDITAR',
            ]);

        ConceptoAccion::create(
            [
                'accion' => 'ELIMINAR',
            ]);

        ConceptoAccion::create(
            [
                'accion' => 'RESTAURAR',
            ]);

        ConceptoPago::factory(5)->create();
        Curso_Grado::factory(5)->create();
        Curso::factory(5)->create();
        DepartamentoAcademico::factory(5)->create();
        DetallePago::factory(5)->create();
        Deuda::factory(5)->create();
        Familiar::factory(5)->create();
        Grado::factory(5)->create();
        Matricula::factory(5)->create();
        NivelEducativo::factory(3)->create();
        Pago::factory(5)->create();
        Personal::factory(5)->create();
        Seccion::factory(5)->create();
        Catedra::factory(5)->create();
    }
}
