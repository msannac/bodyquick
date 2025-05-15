<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entrenador extends Model
{
    use HasFactory;

    // Especifica el nombre correcto de la tabla
    protected $table = 'entrenadores';

    protected $fillable = [
        'nombre', 'apellidos', 'dni', 'telefono', 'especialidad', 'profile_photo_path'
    ];
}
