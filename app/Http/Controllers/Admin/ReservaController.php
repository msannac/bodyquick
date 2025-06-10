<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reserva;

class ReservaController extends Controller
{
    // Muestra el listado de reservas (con búsqueda AJAX por cliente, letras en cualquier orden, incluyendo apellidos)
    public function index(Request $request)
    {
        $query = Reserva::with(['cita', 'cliente'])->orderByDesc('created_at');
        if ($request->filled('cliente') && strlen($request->cliente) >= 3) {
            $letras = mb_str_split(strtolower($request->cliente));
            // Primer filtro: al menos una letra en el nombre o apellidos
            $query->whereHas('cliente', function ($q) use ($letras) {
                foreach ($letras as $letra) {
                    $q->where(function($subq) use ($letra) {
                        $subq->whereRaw('LOWER(name) LIKE ?', ["%$letra%"])
                             ->orWhereRaw('LOWER(apellidos) LIKE ?', ["%$letra%"]);
                    });
                }
            });
            $reservas = $query->get();
            // Segundo filtro: todas las letras presentes en el nombre o apellidos (en cualquier orden)
            $reservas = $reservas->filter(function($reserva) use ($letras) {
                $nombreCompleto = strtolower(($reserva->cliente->name ?? '') . ' ' . ($reserva->cliente->apellidos ?? ''));
                foreach ($letras as $letra) {
                    if (strpos($nombreCompleto, $letra) === false) {
                        return false;
                    }
                }
                return true;
            })->values();
        } else {
            $reservas = $query->get();
        }
        if ($request->ajax()) {
            $tbody = view('Admin.Reservas.partials.tbody', compact('reservas'))->render();
            return response()->json(['tbody' => $tbody]);
        }
        return view('Admin.Reservas.index', compact('reservas'));
    }

    // Muestra el formulario de creación de reserva
    public function create()
    {
            return 'La ruta funciona correctamente';
        //$citas = \App\Models\Cita::with('actividad')->orderBy('fecha')->get();
        //$clientes = \App\Models\User::orderBy('name')->get();
        //$actividades = \App\Models\Actividad::where('activo', true)->orderBy('nombre')->get();
        //return view('Admin.Reservas.crear', compact('citas', 'clientes', 'actividades'));
    }

    // Guarda una nueva reserva
    public function store(Request $request)
    {
        // Validación básica (ajusta según tus necesidades)
        $validated = $request->validate([
            'cita_id' => 'required|exists:citas,id',
            'user_id' => 'required|exists:users,id',
            // ...otros campos necesarios...
        ]);
        $reserva = Reserva::create($validated);
        // Aquí puedes añadir lógica para crear el evento en Google Calendar

        if ($request->ajax()) {
            $reservas = Reserva::with(['cita', 'cliente'])->orderByDesc('created_at')->get();
            $tbody = view('Admin.Reservas.partials.tbody', compact('reservas'))->render();
            return response()->json([
                'success' => true,
                'message' => 'Reserva creada correctamente',
                'tbody' => $tbody
            ]);
        }
        return redirect()->route('admin.reservas.listar')->with('success', 'Reserva creada correctamente');
    }

    // Muestra el formulario de edición de reserva
    public function edit($id)
    {
        $reserva = Reserva::findOrFail($id);
        $clientes = \App\Models\User::orderBy('name')->get();
        $actividades = \App\Models\Actividad::where('activo', true)->orderBy('nombre')->get();
        // Obtener la cita actual de la reserva
        $citaActual = $reserva->cita;
        return view('Admin.Reservas.editar', compact('reserva', 'clientes', 'actividades', 'citaActual'));
    }

    // Actualiza una reserva existente
    public function update(Request $request, $id)
    {
        $reserva = Reserva::findOrFail($id);
        $validated = $request->validate([
            'cita_id' => 'required|exists:citas,id',
            'user_id' => 'required|exists:users,id',
            // ...otros campos necesarios...
        ]);
        $reserva->update($validated);
        // Aquí puedes añadir lógica para actualizar el evento en Google Calendar

        if ($request->ajax()) {
            $reservas = Reserva::with(['cita', 'cliente'])->orderByDesc('created_at')->get();
            $tbody = view('Admin.Reservas.partials.tbody', compact('reservas'))->render();
            return response()->json([
                'success' => true,
                'message' => 'Reserva actualizada correctamente',
                'tbody' => $tbody
            ]);
        }
        return redirect()->route('admin.reservas.listar')->with('success', 'Reserva actualizada correctamente');
    }

    // Elimina una reserva (para AJAX o petición normal)
    public function destroy($id)
    {
        $reserva = Reserva::findOrFail($id);
        // Aquí iría la lógica para eliminar el evento de Google Calendar si aplica
        $reserva->delete();
        if (request()->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.reservas.listar')->with('success', 'Reserva eliminada correctamente');
    }

    // AJAX: Días disponibles para una actividad (admin)
    public function diasDisponibles(Request $request)
    {
        $actividad_id = $request->actividad_id;
        if (!$actividad_id) {
            return response()->json(['error' => 'El ID de la actividad es obligatorio'], 400);
        }
        $hoy = now();
        $limite = $hoy->copy()->addDays(30);
        $dias = \App\Models\Cita::where('actividad_id', $actividad_id)
            ->whereBetween('fecha', [$hoy, $limite])
            ->pluck('fecha')
            ->unique()
            ->values();
        return response()->json($dias);
    }

    // AJAX: Huecos disponibles para una actividad y fecha (admin)
    public function huecosDisponibles(Request $request)
    {
        $actividad_id = $request->actividad_id;
        $fecha = $request->fecha;
        if (!$actividad_id || !$fecha) {
            return response()->json(['error' => 'Parámetros faltantes'], 400);
        }
        $huecos = \App\Models\Cita::where('actividad_id', $actividad_id)
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
