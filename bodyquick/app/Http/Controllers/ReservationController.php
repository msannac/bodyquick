<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reserva;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    // Muestra el formulario de reserva
    public function create()
    {
        return view('reservas.create');
    }

    // Procesa el formulario y guarda la reserva
    public function store(Request $request)
    {
        $validated = $request->validate([
            'fecha'       => 'required|date',
            'hora'        => 'required',
            'tipo_sesion' => 'required|in:entrenamiento convencional,entrenamiento con chaleco de electroestimulacion,readaptacion de lesiones'
        ]);

        Reserva::create([
            'user_id'    => Auth::id(),
            'fecha'      => $validated['fecha'],
            'hora'       => $validated['hora'],
            'tipo_sesion'=> $validated['tipo_sesion'],
            'estado'     => 'pendiente' // estado inicial
        ]);

        return redirect()->route('dashboard')->with('status', 'Reserva creada correctamente');
    }
}
