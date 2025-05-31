<?php

namespace Database\Factories;

use App\Models\ConceptoPago;
use App\Models\Deuda;
use App\Models\Pago;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\DetallePago>
 */
class DetallePagoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_pago'=> Pago::factory(),
            'id_deuda' => Deuda::factory(),
            'id_concepto' => ConceptoPago::factory(),
            'fecha_pago' => fake()->dateTimeBetween('-1 year', 'now'),
            'monto' => fake()->numberBetween(0, 1000),
            'observacion' => fake()->optional()->sentence(),
            'estado' => '1'
        ];
    }
}
