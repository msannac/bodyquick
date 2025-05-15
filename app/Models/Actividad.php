<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    // Indica explícitamente el nombre de la tabla
    protected $table = 'actividades';

    // Atributos asignables
    protected $fillable = [
        'nombre',
        'descripcion',
        'activo',
    ];
}
