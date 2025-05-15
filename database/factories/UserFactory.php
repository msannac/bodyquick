<?php

namespace Database\Factories;

use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            // Genera un apellido ficticio
            'apellidos' => fake()->lastName(),
            // Genera un DNI único con 9 dígitos
            'dni' => fake()->unique()->numerify('#########'),
            // Genera un número de teléfono ficticio
            'telefono' => fake()->phoneNumber(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'two_factor_secret' => null,
            'two_factor_recovery_codes' => null,
            'remember_token' => Str::random(10),
            // Genera una URL ficticia para la foto de perfil
            'profile_photo_path' => fake()->imageUrl(640, 480, 'people', true, 'Faker'),
            // ID del equipo actual, se deja como null por defecto
            'current_team_id' => null, // Puedes asignar un ID válido si es necesario
            // Indica si el usuario es administrador
            'is_admin' => false,
        ];
    }

    /**
     * Indica que el correo electrónico del modelo debe estar sin verificar.
     */
    public function sinVerificar(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Indica que el usuario debe tener un equipo personal.
     */
    public function conEquipoPersonal(?callable $callback = null): static
    {
        if (! Features::hasTeamFeatures()) {
            return $this->state([]);
        }

        return $this->has(
            Team::factory()
                ->state(fn (array $attributes, User $user) => [
                    'name' => $user->name.'\'s Team',
                    'user_id' => $user->id,
                    'personal_team' => true,
                ])
                ->when(is_callable($callback), $callback),
            'ownedTeams'
        );
    }
}
