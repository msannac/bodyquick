<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    // Atributos asignables
    protected $fillable = [
        'fecha',           // Fecha de la cita (tipo date)
        'hueco',           // Puede ser un campo de texto para identificar el hueco
        'aforo',           // Número entero que indica el aforo
        'hora_inicio',     // Hora de inicio (podría ser string o time)
        'duracion',        // Duración en minutos, por ejemplo
        'frecuencia',      // Por ejemplo: una_vez, cada_semana, cada_mes
        'actividad_id',    // Relación con la actividad
    ];

    // Relación con la actividad
    public function actividad()
    {
        return $this->belongsTo(Actividad::class);
    }

    // Relación con la reserva
    public function reserva()
    {
        return $this->hasOne(\App\Models\Reserva::class, 'cita_id');
    }
}
