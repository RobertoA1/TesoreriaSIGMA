<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RegistroHistorico>
 */
class RegistroHistoricoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_autor' => Usser::factory(['tipo' => 'Autor']),
            'id_concepto_accion' => ConceptoAccion::factory(),
            'id_usuario_afectado' => Usser::factory(),
            'fecha_accion' => fake()->dateTimeBetween('-1 year', 'now'),
            'observacion' => fake()->sentence(),
            'estado' => '1'
        ];
    }
}
