<?php

namespace Database\Factories;

use App\Models\Reserva;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Reserva>
 */
class ReservaFactory extends Factory
{
    /**
     * El nombre del modelo correspondiente a esta factory.
     *
     * @var string
     */
    protected $model = Reserva::class;

    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Genera un ID ficticio para el usuario
            'user_id' => fake()->randomDigitNotNull(),
            // Genera un ID ficticio para la cita
            'cita_id' => fake()->randomDigitNotNull(),
        ];
    }
}
