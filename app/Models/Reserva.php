<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'cita_id',
        'user_id',
        
    ];

    // Relación con la cita
    public function cita()
    {
        return $this->belongsTo(\App\Models\Cita::class, 'cita_id');
    }

    // Relación con el cliente
    public function cliente()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
