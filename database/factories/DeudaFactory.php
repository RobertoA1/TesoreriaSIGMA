<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Deuda>
 */
class DeudaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_alumno' => Alumno::factory(),
            'id_concepto' => ConceptoPago::factory(),
            'fecha_limite' => fake()->dateTimeBetween('now', '+1 year'),
            'monto_total' => fake()->numberBetween(0, 5000),
            'periodo' => fake()->randomElement(['2024', '2025', '2026', '2027', '2028']),
            'monto_a_cuenta' => fake()->numberBetween(0, 1000),
            'monto_adelantado' => fake()->numberBetween(0, 1000),
            'descripcion' => fake()->optional()->sentence(),
            'estado' => '1'
        ];
    }
}
