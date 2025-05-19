<?php

namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;
use App\Models\Actividad;
use App\Models\Cita;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReservaCreadaClienteMail;
use App\Mail\ReservaCreadaAdminMail;
use App\Mail\ReservaAnuladaClienteMail;
use App\Mail\ReservaAnuladaAdminMail;
use App\Mail\ReservaActualizadaClienteMail;
use App\Mail\ReservaActualizadaAdminMail;
use App\Models\User;
use Illuminate\Support\Facades\Log;

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

        // Validar aforo antes de crear la reserva
        $cita = Cita::find($data['cita_id']);
        $num_reservas = Reserva::where('cita_id', $cita->id)->count();
        if ($num_reservas >= $cita->aforo) {
            return redirect()->back()->withErrors(['cita_id' => 'aforo completo'])->withInput();
        }

        $reserva = Reserva::create($data);
        $actividad = $cita->actividad;
        $cliente = Auth::user();

        // Enviar email al cliente
        Mail::to($cliente->email)->send(new ReservaCreadaClienteMail($reserva, $cita, $actividad));

        // Enviar email al admin (pueden ser varios, aquí se envía al primero encontrado)
        $admin = User::where('is_admin', true)->first();
        if ($admin) {
            Mail::to($admin->email)->send(new ReservaCreadaAdminMail($reserva, $cita, $actividad, $cliente));
        }

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

        // Comprobar si faltan al menos 24 horas para la cita
        $cita = $reserva->cita;
        $fechaHoraCita = \Carbon\Carbon::parse($cita->fecha . ' ' . $cita->hora_inicio);
        if (now()->diffInHours($fechaHoraCita, false) < 24) {
            return redirect()->route('cliente.reservas.index')
                ->with('error', 'No puedes modificar una reserva con menos de 24 horas de antelación. Si tienes una urgencia, contacta con el centro.');
        }

        $data = $request->validate([
            'actividad' => 'required|exists:actividades,id',
            'fecha'     => 'required|date',
            'cita_id'   => 'required|exists:citas,id',
        ]);

        // Validar aforo antes de actualizar la reserva
        $cita = Cita::find($data['cita_id']);
        $num_reservas = Reserva::where('cita_id', $cita->id)
            ->where('id', '!=', $reserva->id) // Excluir la reserva actual
            ->count();
        if ($num_reservas >= $cita->aforo) {
            return redirect()->back()->withErrors(['cita_id' => 'aforo completo'])->withInput();
        }
        
        // Actualizar la cita asociada a la reserva
        $reserva->cita->update([
            'actividad_id' => $data['actividad'],
            'fecha'        => $data['fecha'],
        ]);

        // Obtener datos para el email
        $actividad = $cita->actividad;
        $cliente = Auth::user();
        
        // Enviar email al cliente (actualización)
        Mail::to($cliente->email)->send(new ReservaActualizadaClienteMail($reserva, $cita, $actividad));

        // Enviar email al admin (actualización)
        $admin = User::where('is_admin', true)->first();
        Log::info('Enviando email de actualización a admin', ['admin' => $admin ? $admin->email : null]);
        if ($admin) {
            Mail::to($admin->email)->send(new ReservaActualizadaAdminMail($reserva, $cita, $actividad, $cliente));
        }
        
        return redirect()->route('cliente.reservas.index')
                         ->with('status', 'Reserva actualizada correctamente');
    }

    public function destroy(Reserva $reserva)
    {
        // Verificar pertenencia y eliminar reserva.
        if ($reserva->user_id !== Auth::id()) {
            abort(403);
        }

        // Comprobar si faltan al menos 24 horas para la cita
        $cita = $reserva->cita;
        $fechaHoraCita = \Carbon\Carbon::parse($cita->fecha . ' ' . $cita->hora_inicio);
        if (now()->diffInHours($fechaHoraCita, false) < 24) {
            return redirect()->route('cliente.reservas.index')
                ->with('error', 'No puedes anular una reserva con menos de 24 horas de antelación. Si tienes una urgencia, contacta con el centro.');
        }

        $actividad = $cita->actividad;
        $cliente = Auth::user();

        // Eliminar la reserva
        $reserva->delete();

        // Enviar email al cliente (anulación)
        Mail::to($cliente->email)->send(new ReservaAnuladaClienteMail($reserva, $cita, $actividad));

        // Enviar email al admin (anulación)
        $admin = User::where('is_admin', true)->first();
        if ($admin) {
            Mail::to($admin->email)->send(new ReservaAnuladaAdminMail($reserva, $cita, $actividad, $cliente));
        }

        return redirect()->route('cliente.reservas.index')
            ->with('status', 'Reserva anulada correctamente');
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

        if (!$actividad_id || !$fecha) {
            return response()->json(['error' => 'Parámetros faltantes'], 400);
        }

        // Obtener los huecos (citas) para la actividad y fecha
        $huecos = Cita::where('actividad_id', $actividad_id)
            ->where('fecha', $fecha)
            ->get(['id', 'hora_inicio', 'duracion', 'aforo']);

        if ($huecos->isEmpty()) {
            return response()->json(['message' => 'No hay huecos disponibles para esta fecha'], 404);
        }

        // Filtrar solo los huecos que no han alcanzado el aforo máximo
        $huecos = $huecos->filter(function ($hueco) {
            $num_reservas = \App\Models\Reserva::where('cita_id', $hueco->id)->count();
            return $num_reservas < $hueco->aforo;
        })->values();

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
