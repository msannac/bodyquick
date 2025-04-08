<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'fecha',
        'hora',
        'tipo_sesion',
        'estado'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
