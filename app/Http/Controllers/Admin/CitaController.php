<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Actividad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Log;

class CitaController extends Controller
{
    /**
     * Lista las citas, con opción de filtrar por fecha, actividad y cliente.
     */
    public function listar(Request $request)
    {
        $fecha = $request->input('fecha', date('Y-m-d'));
        $actividad_id = $request->input('actividad_id', '');
        $cliente_id = $request->input('cliente_id', '');

        $consulta = Cita::query();

        // Filtrar por fecha
        if ($request->filled('fecha')) {
            $consulta->where('fecha', $fecha);
        }

        // Filtrar por actividad (si se pasa en el request)
        if ($request->filled('actividad_id')) {
            $consulta->where('actividad_id', $actividad_id);
        }

        // Filtrar por cliente utilizando la relación reserva
        if ($request->filled('cliente_id')) {
            $consulta->whereHas('reserva', function (Builder $query) use ($cliente_id) {
                $query->where('user_id', $cliente_id);
            });
        }

        // Filtrar por cliente por nombre (usando la relación reserva.cliente)
        if ($request->filled('cliente')) {
            $cliente = $request->cliente;
            $consulta->whereHas('reserva.cliente', function ($query) use ($cliente) {
                $query->where('name', 'LIKE', '%' . $cliente . '%');
            });
        }

        $citas = $consulta->with(['actividad', 'reserva.cliente'])->paginate(15);

        $clientes = User::where('is_admin', false)->get();
        $actividades = Actividad::all();

        // Si la petición es AJAX, devolver solo el <tbody> de la tabla
        if ($request->ajax()) {
            return view('Admin.Citas.partials.tbody', compact('citas'))->render();
        }

        return view('Admin.Citas.index', compact('citas', 'fecha', 'actividad_id', 'cliente_id', 'clientes', 'actividades'));
    }

    /**
     * Muestra el formulario para crear una nueva cita.
     */
    public function crear(Request $request)
    {
        $actividades = \App\Models\Actividad::all();
        // Siempre devolver la vista crear.blade.php, tanto para AJAX como normal
        return view('Admin.Citas.crear', compact('actividades'));
    }

    /**
     * Almacena una nueva cita en la base de datos.
     */
    public function almacenar(Request $request)
    {
        if ($request->has('masiva') && $request->masiva == 1) {
            // Ignorar campos individuales si llegan por error
            $request->merge([
                'fecha' => null,
                'hueco' => null,
                'hora_inicio' => null,
                'frecuencia_individual' => null,
            ]);
            $data = $request->validate([
                'actividad_id'  => 'required|exists:actividades,id',
                'aforo'         => 'required|integer',
                'duracion'      => 'required|integer',
                'frecuencia'    => 'required|in:diaria,semanal,mensual',
                'fecha_inicio'  => 'required|date',
                'fecha_fin'     => 'required|date|after_or_equal:fecha_inicio',
            ]);

            $fechaInicio = \Carbon\Carbon::parse($data['fecha_inicio']);
            $fechaFin = \Carbon\Carbon::parse($data['fecha_fin']);
            $incremento = [
                'diaria'   => \Carbon\CarbonInterval::days(1),
                'semanal'  => \Carbon\CarbonInterval::weeks(1),
                'mensual'  => \Carbon\CarbonInterval::months(1),
            ][$data['frecuencia']];

            $actividad = \App\Models\Actividad::find($data['actividad_id']);
            if (!$actividad) {
                return redirect()->back()->withErrors(['actividad_id' => 'Actividad no encontrada']);
            }
            $duracion = (int) $data['duracion'];

            $horarios = [
                ['inicio' => '07:00', 'fin' => '13:00'],
                ['inicio' => '17:00', 'fin' => '21:00'],
            ];

            // Calcular cuántas citas se crearán (estimación)
            $totalCitas = 0;
            for ($fecha = $fechaInicio->copy(); $fecha->lte($fechaFin); $fecha->add($incremento)) {
                foreach ($horarios as $horario) {
                    $inicio = \Carbon\Carbon::createFromFormat('H:i', $horario['inicio']);
                    $fin = \Carbon\Carbon::createFromFormat('H:i', $horario['fin']);
                    while ($inicio->copy()->addMinutes($duracion)->lte($fin)) {
                        $totalCitas++;
                        $inicio = $inicio->addMinutes($duracion)->clone();
                    }
                }
            }
            $maxCitas = 5000;
            if ($totalCitas > $maxCitas) {
                return redirect()->back()->withErrors(['masiva' => 'Demasiadas citas a crear de golpe ('.$totalCitas.'). Reduce el rango de fechas o ajusta la duración. Máximo permitido: '.$maxCitas]);
            }

            // Crear citas
            $citasCreadas = 0;
            for ($fecha = $fechaInicio->copy(); $fecha->lte($fechaFin); $fecha->add($incremento)) {
                foreach ($horarios as $horario) {
                    $inicio = \Carbon\Carbon::createFromFormat('H:i', $horario['inicio']);
                    $fin = \Carbon\Carbon::createFromFormat('H:i', $horario['fin']);
                    while ($inicio->copy()->addMinutes($duracion)->lte($fin)) {
                        $hueco_inicio = $inicio->format('H:i');
                        $hueco_fin = $inicio->copy()->addMinutes($duracion)->format('H:i');
                        $hueco = $hueco_inicio . ' - ' . $hueco_fin;
                        \App\Models\Cita::create([
                            'fecha'         => $fecha->format('Y-m-d'),
                            'hueco'         => $hueco,
                            'aforo'         => $data['aforo'],
                            'hora_inicio'   => $hueco_inicio,
                            'duracion'      => $duracion,
                            'frecuencia'    => $data['frecuencia'],
                            'actividad_id'  => $data['actividad_id'],
                        ]);
                        $citasCreadas++;
                        $inicio = $inicio->addMinutes($duracion)->clone();
                    }
                }
            }

            return redirect()->route('admin.citas.listar')
                             ->with('status', $citasCreadas.' citas creadas correctamente (modo masivo, todos los huecos).');
        } else {
            // Validación para creación individual (sin cliente_id)
            $data = $request->validate([
                'fecha'                  => 'required|date',
                'hueco'                  => 'required|string',
                'aforo'                  => 'required|integer',
                'hora_inicio'            => 'required',
                'duracion'               => 'required|integer',
                'frecuencia_individual'  => 'required|in:una_vez,cada_semana,cada_mes',
                'actividad_id'           => 'required|exists:actividades,id',
            ]);

            // Usamos el campo frecuencia_individual para asignar al campo "frecuencia"
            $data['frecuencia'] = $data['frecuencia_individual'];

            Cita::create([
                'fecha'         => $data['fecha'],
                'hueco'         => $data['hueco'],
                'aforo'         => $data['aforo'],
                'hora_inicio'   => $data['hora_inicio'],
                'duracion'      => $data['duracion'],
                'frecuencia'    => $data['frecuencia'],
                'actividad_id'  => $data['actividad_id'],
            ]);

            return redirect()->route('admin.citas.listar')
                             ->with('status', 'Cita creada correctamente.');
        }
    }

    /**
     * Muestra el formulario para crear citas de forma masiva.
     */
    public function crearMasiva()
    {
        $actividades = \App\Models\Actividad::all();
        return view('Admin.Citas.crear_masiva', compact('actividades'));
    }

    /**
     * Almacena citas de forma masiva en la base de datos.
     */
    public function almacenarMasiva(Request $request)
    {
        $data = $request->validate([
            'actividad_id'  => 'required|exists:actividades,id',
            'aforo'         => 'required|integer',
            'duracion'      => 'required|integer',
            'frecuencia'    => 'required|in:una_vez,cada_semana,cada_mes',
            'fecha_inicio'  => 'required|date',
            'fecha_fin'     => 'required|date|after_or_equal:fecha_inicio',
        ]);

        $fechaInicio = \Carbon\Carbon::parse($data['fecha_inicio']);
        $fechaFin = \Carbon\Carbon::parse($data['fecha_fin']);
        $incrementos = [
            'una_vez'     => \Carbon\CarbonInterval::days(1),
            'cada_semana' => \Carbon\CarbonInterval::weeks(1),
            'cada_mes'    => \Carbon\CarbonInterval::months(1),
        ];
        $frecuenciaRecibida = trim((string) $data['frecuencia']);
        $incremento = $incrementos[$frecuenciaRecibida] ?? null;
        if (!$incremento || !($incremento instanceof \DateInterval)) {
            Log::error('Incremento inválido en creación masiva de citas', [
                'frecuencia_recibida' => $frecuenciaRecibida,
                'data' => $data,
                'incremento' => $incremento,
                'tipo_incremento' => gettype($incremento)
            ]);
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Frecuencia inválida: ' . $frecuenciaRecibida], 422);
            }
            return redirect()->back()->withErrors(['frecuencia' => 'Frecuencia inválida: ' . $frecuenciaRecibida]);
        }

        $actividad = \App\Models\Actividad::find($data['actividad_id']);
        if (!$actividad) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Actividad no encontrada'], 422);
            }
            return redirect()->back()->withErrors(['actividad_id' => 'Actividad no encontrada']);
        }
        $duracion = (int) $data['duracion'];

        $horarios = [
            ['inicio' => '07:00', 'fin' => '13:00'],
            ['inicio' => '17:00', 'fin' => '21:00'],
        ];

        Log::info('DEBUG masiva: frecuencia, incremento y data', [
            'frecuencia_recibida' => $frecuenciaRecibida,
            'incremento' => $incremento,
            'tipo_incremento' => gettype($incremento),
            'data' => $data
        ]);

        // Calcular cuántas citas se crearán (estimación)
        $totalCitas = 0;
        for ($fecha = $fechaInicio->copy(); $fecha->lte($fechaFin); $fecha->add($incremento)) {
            foreach ($horarios as $horario) {
                $inicio = \Carbon\Carbon::createFromFormat('H:i', $horario['inicio']);
                $fin = \Carbon\Carbon::createFromFormat('H:i', $horario['fin']);
                while ($inicio->copy()->addMinutes($duracion)->lte($fin)) {
                    $totalCitas++;
                    $inicio = $inicio->addMinutes($duracion)->clone();
                }
            }
        }
        $maxCitas = 5000;
        if ($totalCitas > $maxCitas) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Demasiadas citas a crear de golpe ('.$totalCitas.'). Reduce el rango de fechas o ajusta la duración. Máximo permitido: '.$maxCitas], 422);
            }
            return redirect()->back()->withErrors(['masiva' => 'Demasiadas citas a crear de golpe ('.$totalCitas.'). Reduce el rango de fechas o ajusta la duración. Máximo permitido: '.$maxCitas]);
        }

        // Crear citas
        $citasCreadas = 0;
        for ($fecha = $fechaInicio->copy(); $fecha->lte($fechaFin); $fecha->add($incremento)) {
            foreach ($horarios as $horario) {
                $inicio = \Carbon\Carbon::createFromFormat('H:i', $horario['inicio']);
                $fin = \Carbon\Carbon::createFromFormat('H:i', $horario['fin']);
                while ($inicio->copy()->addMinutes($duracion)->lte($fin)) {
                    $hueco_inicio = $inicio->format('H:i');
                    $hueco_fin = $inicio->copy()->addMinutes($duracion)->format('H:i');
                    $hueco = $hueco_inicio . ' - ' . $hueco_fin;
                    \App\Models\Cita::create([
                        'fecha'         => $fecha->format('Y-m-d'),
                        'hueco'         => $hueco,
                        'aforo'         => $data['aforo'],
                        'hora_inicio'   => $hueco_inicio,
                        'duracion'      => $duracion,
                        'frecuencia'    => $data['frecuencia'],
                        'actividad_id'  => $data['actividad_id'],
                    ]);
                    $citasCreadas++;
                    $inicio = $inicio->addMinutes($duracion)->clone();
                }
            }
        }

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'mensaje' => $citasCreadas.' citas creadas correctamente (modo masivo, todos los huecos).']);
        }
        return redirect()->route('admin.citas.listar')
                         ->with('status', $citasCreadas.' citas creadas correctamente (modo masivo, todos los huecos).');
    }

    /**
     * Muestra el formulario para editar una cita existente.
     */
    public function editar(Request $request, Cita $cita)
    {
        // Siempre devolver la vista editar.blade.php, tanto para AJAX como normal
        return view('Admin.Citas.editar', compact('cita'));
    }

    /**
     * Actualiza la cita en la base de datos.
     */
    public function actualizar(Request $request, Cita $cita)
    {
        $datos = $request->validate([
            'fecha'         => 'required|date',
            'hueco'         => 'required|string',
            'aforo'         => 'required|integer',
            'hora_inicio'   => 'required',
            'duracion'      => 'required|integer',
            'frecuencia'    => 'required|in:una_vez,cada_semana,cada_mes',
            'actividad_id'  => 'required|exists:actividades,id',
        ]);

        $cita->update($datos);

        return redirect()->route('admin.citas.listar')->with('status', 'Cita actualizada correctamente.');
    }

    /**
     * Elimina una cita de la base de datos.
     */
    public function eliminar(Cita $cita)
    {
        $cita->delete();

        return redirect()->route('admin.citas.listar')->with('status', 'Cita eliminada correctamente.');
    }

    /**
     * Devuelve los huecos disponibles para una actividad y fecha (AJAX) según la lógica real del gimnasio.
     */
    public function huecosDisponibles(Request $request)
    {
        $actividad_id = $request->input('actividad_id');
        $fecha = $request->input('fecha');
        $huecos = [];

        // Obtener la actividad para saber el tipo
        $actividad = \App\Models\Actividad::find($actividad_id);
        if (!$actividad || !$fecha) {
            return response()->json($huecos);
        }

        // Lógica de horarios
        $horarios = [
            ['inicio' => '07:00', 'fin' => '13:00'],
            ['inicio' => '17:00', 'fin' => '21:00'],
        ];

        // Determinar duración según tipo de actividad
        $nombre = strtolower($actividad->nombre);
        if (str_contains($nombre, 'electro')) {
            $duracion = 20;
        } else {
            // Entrenamiento personal y readaptación
            $duracion = 60;
        }

        // Generar huecos para cada franja horaria
        foreach ($horarios as $horario) {
            $inicio = \Carbon\Carbon::createFromFormat('H:i', $horario['inicio']);
            $fin = \Carbon\Carbon::createFromFormat('H:i', $horario['fin']);
            while ($inicio->copy()->addMinutes($duracion) <= $fin) {
                $hueco_inicio = $inicio->format('H:i');
                $hueco_fin = $inicio->copy()->addMinutes($duracion)->format('H:i');
                $huecos[] = $hueco_inicio . ' - ' . $hueco_fin;
                $inicio->addMinutes($duracion);
            }
        }

        

        return response()->json($huecos);
    }
}
