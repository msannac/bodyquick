<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Actividad;
use App\Models\Cita;
use Illuminate\Support\Facades\Auth;

class ReservaController extends Controller
{
    // Listado de reservas del cliente autenticado
    public function index()
    {
        $reservas = Reserva::with('cita.actividad')
                    ->where('user_id', Auth::id())
                    ->get();
        return view('cliente.reservas.index', compact('reservas'));
    }

    public function create()
    {
        $actividades = \App\Models\Actividad::where('activo', true)->get();
        return view('cliente.reservas.nueva', compact('actividades'));
    }

    public function store(Request $request)
    {
        // Valida y crea la reserva
        $data = $request->validate([
            'cita_id' => 'required|exists:citas,id',
            // Agrega otras reglas si es necesario
        ]);
        $data['user_id'] = Auth::id();
        Reserva::create($data);
        return redirect()->route('cliente.reservas.index')
                         ->with('status', 'Reserva creada correctamente');
    }

    public function edit(Reserva $reserva)
    {
        // Verificar que la reserva pertenezca al usuario
        if ($reserva->user_id !== Auth::id()) {
            abort(403);
        }
        $actividades = Actividad::where('activo', true)->get();
        return view('cliente.reservas.edit', compact('reserva', 'actividades'));
    }

    public function update(Request $request, Reserva $reserva)
    {
        // Verificar que la reserva pertenezca al usuario autenticado
        if ($reserva->user_id !== Auth::id()) {
            abort(403);
        }
        
        $data = $request->validate([
            'actividad' => 'required|exists:actividades,id',
            'fecha'     => 'required|date',
            'cita_id'   => 'required|exists:citas,id',
        ]);
        
        // Actualizar la cita asociada a la reserva
        $reserva->cita->update([
            'actividad_id' => $data['actividad'],
            'fecha'        => $data['fecha'],
            // En este ejemplo, se asume que el campo "hueco" se actualiza indirectamente 
            // a través de "cita_id". Si se necesita actualizar otro campo, agrégalo aquí.
        ]);
        
        return redirect()->route('cliente.reservas.index')
                         ->with('status', 'Reserva actualizada correctamente');
    }

    public function destroy(Reserva $reserva)
    {
        // Verificar pertenencia y eliminar reserva.
        if ($reserva->user_id !== Auth::id()) {
            abort(403);
        }
        $reserva->delete();
        return redirect()->route('cliente.reservas.index')
                         ->with('status', 'Reserva eliminada correctamente');
    }

    public function diasDisponibles(Request $request)
    {
        $actividad_id = $request->actividad_id;

        // Validar que el parámetro requerido esté presente
        if (!$actividad_id) {
            return response()->json(['error' => 'El ID de la actividad es obligatorio'], 400);
        }

        // Obtener los días únicos disponibles para la actividad, limitados a los próximos 30 días
        $hoy = now();
        $limite = $hoy->copy()->addDays(30);

        $dias = Cita::where('actividad_id', $actividad_id)
            ->whereBetween('fecha', [$hoy, $limite])
            ->pluck('fecha')
            ->unique()
            ->values(); // Asegura índices consecutivos

        return response()->json($dias);
    }

    public function huecosDisponibles(Request $request)
    {
        $actividad_id = $request->actividad_id;
        $fecha = $request->fecha;

        // Validar que los parámetros requeridos estén presentes
        if (!$actividad_id || !$fecha) {
            return response()->json(['error' => 'Parámetros faltantes'], 400);
        }

        // Filtrar huecos disponibles dentro del horario del gimnasio
        $huecos = Cita::where('actividad_id', $actividad_id)
            ->where('fecha', $fecha)
            ->get(['id', 'hora_inicio', 'duracion']);

        // Verificar si hay huecos disponibles
        if ($huecos->isEmpty()) {
            return response()->json(['message' => 'No hay huecos disponibles para esta fecha'], 404);
        }

        // Calcular hora_fin basado en hora_inicio y duracion
        $huecos = $huecos->map(function ($hueco) {
            $hora_inicio = new \DateTime($hueco->hora_inicio);
            $hora_fin = clone $hora_inicio;
            $hora_fin->modify("+{$hueco->duracion} minutes");

            return [
                'id' => $hueco->id,
                'hora_inicio' => $hueco->hora_inicio,
                'hora_fin' => $hora_fin->format('H:i:s'),
            ];
        });

        return response()->json($huecos);
    }
}
