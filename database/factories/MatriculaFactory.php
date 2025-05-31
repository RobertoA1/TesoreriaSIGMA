<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Matricula>
 */
class MatriculaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_matricula'=> Matricula::factory(),
            'id_alumno' => Alumno::factory(),
            'año_escolar' => fake()->randomElement(['2024', '2025', '2026', '2027', '2028']),
            'fecha_matricula' => fake()->dateTimeBetween('-1 year', 'now'),
            'escala' => fake()->randomElement(['A', 'B', 'C', 'D', 'E']),
            'observaciones' => fake()->sentence(),
            'id_grado' => $seccion?->id_grado,
            'secciones_nombreSeccion' => $seccion?->nombreSeccion,
            'estado'=>'1'
        ];
    }
}
