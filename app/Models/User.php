<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Producto;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;

    /**
     * Los atributos que se pueden asignar masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin', 
        'apellidos', 
        'dni', 
        'telefono', 
    ];

    /**
     * Los atributos que deben estar ocultos para la serialización.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * Los accesores que se deben agregar a la forma de matriz del modelo.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Obtener los atributos que deben ser convertidos.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Devuelve la URL de la foto de perfil, o una por defecto si no hay.
     */
    public function getProfilePhotoUrlAttribute()
    {
        if ($this->profile_photo_path) {
            // Si la ruta ya es una URL absoluta (por ejemplo, empieza por http), la devolvemos tal cual
            if (str_starts_with($this->profile_photo_path, 'http')) {
                return $this->profile_photo_path;
            }
            // Si la ruta ya es relativa a storage/app/public
            return asset('storage/' . ltrim($this->profile_photo_path, '/'));
        }
        return asset('images/default-profile.jpg');
    }

    // Relación N:M con productos a través de carrito
    public function productos()
    {
        return $this->belongsToMany(Producto::class, 'carrito', 'user_id', 'producto_id');
    }

    // Un usuario tiene muchos pedidos
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
