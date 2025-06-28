<?php

namespace Database\Seeders;

use App\Models\Administrativo;
use App\Models\Alumno;
use App\Models\Catedra;
use App\Models\ComposicionFamiliar;
use App\Models\ConceptoPago;
use App\Models\Curso;
use App\Models\DepartamentoAcademico;
use App\Models\Deuda;
use App\Models\Familiar;
use App\Models\Grado;
use App\Models\Matricula;
use App\Models\NivelEducativo;
use App\Models\Personal;
use App\Models\Seccion;
use App\Models\User;
use App\Observers\Traits\LogsActions;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class UsuariosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Deshabilitamos temporalmente el registro de acciones, ya que estamos ejecutando un seeder.
        LogsActions::disable();

        Administrativo::create([
            'id_usuario' => User::factory([
                'username' => 'director',
                'password' => bcrypt("12345"),
                'tipo' => 'Administrativo',
            ])->create()->id_usuario,

            'apellido_paterno' => fake()->lastName(),
            'apellido_materno' => fake()->lastName(),
            'primer_nombre' => fake()->firstName(),
            'otros_nombres' => fake()->randomElement([fake()->name(), fake()->name() . " " . fake()->name()]),
            'dni' => fake()->numberBetween(10000000, 99999999),
            'direccion' => fake()->address(),
            'estado_civil' => fake()->randomElement(['S', 'C', 'V', 'D']),
            'telefono' => fake()->phoneNumber(),
            'seguro_social' => fake()->numberBetween('1000000000'),
            'fecha_ingreso' => fake()->dateTimeThisDecade(),
            'cargo' => 'Director',
            'sueldo' => fake()->numberBetween(5000, 10000),
            'estado' => '1'
        ]);

        Administrativo::create([
            'id_usuario' => User::factory([
                'username' => 'secretaria',
                'password' => bcrypt("12345"),
                'tipo' => 'Administrativo',
            ])->create()->id_usuario,
            
            'apellido_paterno' => fake()->lastName(),
            'apellido_materno' => fake()->lastName(),
            'primer_nombre' => fake()->firstName(),
            'otros_nombres' => fake()->randomElement([fake()->name(), fake()->name() . " " . fake()->name()]),
            'dni' => fake()->numberBetween(10000000, 99999999),
            'direccion' => fake()->address(),
            'estado_civil' => fake()->randomElement(['S', 'C', 'V', 'D']),
            'telefono' => fake()->phoneNumber(),
            'seguro_social' => fake()->numberBetween('1000000000'),
            'fecha_ingreso' => fake()->dateTimeThisDecade(),
            'cargo' => 'Secretaria',
            'sueldo' => fake()->numberBetween(1500, 3500),
            'estado' => '1'
        ]);


        $anioActual = Carbon::now()->year;
        $fechaNacimiento = Carbon::now()->subYears(10)->format('Y-m-d');
        $fechaBautizo = Carbon::now()->subYears(9)->format('Y-m-d');

        $alumno = Alumno::create([
            'codigo_educando' => '123456',
            'codigo_modular' => '123456',
            'año_ingreso' => $anioActual,
            'dni' => '12345678',
            'apellido_paterno' => 'García',
            'apellido_materno' => 'Lopez',
            'primer_nombre' => 'Juan',
            'otros_nombres' => 'Pablo',
            'sexo' => 'M',
            'fecha_nacimiento' => $fechaNacimiento,
            'pais' => 'Perú',
            'departamento' => 'La Libertad',
            'provincia' => 'Trujillo',
            'distrito' => 'Trujillo',
            'lengua_materna' => 'CASTELLANO',
            'estado_civil' => 'S',
            'religion' => 'Catolica',
            'fecha_bautizo' => $fechaBautizo,
            'parroquia_bautizo' => null,
            'colegio_procedencia' => null,
            'direccion' => 'Calle Falsa 123',
            'telefono' => '+51 912345678',
            'medio_transporte' => 'A PIE',
            'tiempo_demora' => '10 min',
            'material_vivienda' => 'LADRILLO/CEMENTO',
            'energia_electrica' => 'INSTALACION DOMICILIARIA',
            'agua_potable' => 'INSTALACION DOMICILIARIA',
            'desague' => 'INSTALACION DOMICILIARIA',
            'ss_hh' => 'INODORO CON AGUA CORRIENTE',
            'num_habitaciones' => 3,
            'num_habitantes' => 4,
            'situacion_vivienda' => 'PROPIA',
            'escala' => 'A',
            'estado' => true
        ]);

        $grado = Grado::where('nombre_grado', 'QUINTO')
            ->whereHas('nivelEducativo', function($q){
                $q->where('nombre_nivel', 'Primaria');
            })->firstOrFail();

        $familiar = Familiar::create([

            'id_usuario' => User::factory([
                'username' => 'familiar_' . $alumno->dni,
                'password' => bcrypt("12345"),
                'tipo' => 'Familiar',
            ])->create()->id_usuario,

            'dni' => fake()->unique()->numberBetween(10000000, 99999999),
            'apellido_paterno' => fake()->lastName(),
            'apellido_materno' => fake()->optional()->lastName(),
            'primer_nombre' => fake()->firstName(),
            'otros_nombres' => fake()->optional()->sentence(3),
            'numero_contacto' => fake()->optional()->phoneNumber(),
            'correo_electronico' => fake()->unique()->safeEmail(),
            'estado' => true
        ]);

        ComposicionFamiliar::create([
            'id_alumno' => $alumno->id_alumno,   
            'id_familiar' => $familiar->idFamiliar, 
            'parentesco' => fake()->randomElement(['Padre', 'Madre', 'Tutor', 'Abuelo', 'Tía']),
            'estado' => true
        ]);


        $matricula = Matricula::create([
            'id_alumno' => $alumno->id_alumno,
            'año_escolar' => $anioActual,
            'fecha_matricula' => now(),
            'escala' => 'A',
            'id_grado' => $grado->id_grado,
            'nombreSeccion' => 'A',
            'estado' => true,
        ]);

        $matricula->generarDeudas();


        // Restablecemos el registro de acciones.
        LogsActions::enable();
    }


    

}
