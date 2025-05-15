<?php

namespace Database\Factories;

use App\Models\Entrenador;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entrenador>
 */
class EntrenadorFactory extends Factory
{
    /**
     * El nombre del modelo correspondiente a esta factory.
     *
     * @var string
     */
    protected $model = Entrenador::class;

    /**
     * Define el estado por defecto del modelo.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Genera un nombre ficticio para el entrenador
            'nombre' => fake()->firstName(),
            // Genera un apellido ficticio para el entrenador
            'apellidos' => fake()->lastName(),
            // Genera un DNI único ficticio
            'dni' => fake()->unique()->numerify('#########'),
            // Genera un número de teléfono ficticio
            'telefono' => fake()->optional()->phoneNumber(),
            // Genera una especialidad ficticia
            'especialidad' => fake()->randomElement(['entrenamiento funcional', 'electroestimulación', 'readaptacion de lesiones']),
            // Genera una URL ficticia para la foto de perfil
            'profile_photo_path' => fake()->optional()->imageUrl(640, 480, 'people', true, 'Faker'),
        ];
    }
}
