<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cita;
use App\Models\Actividad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

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
                // Cambiar 'cliente_id' por 'user_id' si este es el nombre real en la tabla reservas.
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

        // Obtener la lista de clientes (usuarios que no son admin) y actividades para el filtro en la vista.
        $clientes = User::where('is_admin', false)->get();
        $actividades = Actividad::all();

        return view('Admin.Citas.index', compact('citas', 'fecha', 'actividad_id', 'cliente_id', 'clientes', 'actividades'));
    }

    /**
     * Muestra el formulario para crear una nueva cita.
     */
    public function crear()
    {
        return view('Admin.Citas.crear');
    }

    /**
     * Almacena una nueva cita en la base de datos.
     */
    public function almacenar(Request $request)
    {
        if ($request->has('masiva') && $request->masiva == 1) {
            // Validación para creación masiva (sin cliente_id)
            $data = $request->validate([
                'actividad_id'  => 'required|exists:actividades,id',
                'hueco'         => 'required|string',
                'aforo'         => 'required|integer',
                'hora_inicio'   => 'required',
                'duracion'      => 'required|integer',
                'frecuencia'    => 'required|in:diaria,semanal,mensual',
                'fecha_inicio'  => 'required|date',
                'fecha_fin'     => 'required|date|after_or_equal:fecha_inicio',
            ]);

            $fechaInicio = \Carbon\Carbon::parse($data['fecha_inicio']);
            $fechaFin = \Carbon\Carbon::parse($data['fecha_fin']);
            $incremento = [
                'diaria'   => \Carbon\CarbonInterval::day(),
                'semanal'  => \Carbon\CarbonInterval::week(),
                'mensual'  => \Carbon\CarbonInterval::month(),
            ][$data['frecuencia']];

            $citasCreadas = 0;
            for ($fecha = $fechaInicio->copy(); $fecha->lte($fechaFin); $fecha->add($incremento)) {
                Cita::create([
                    'fecha'         => $fecha->toDateString(),
                    'hueco'         => $data['hueco'],
                    'aforo'         => $data['aforo'],
                    'hora_inicio'   => $data['hora_inicio'],
                    'duracion'      => $data['duracion'],
                    'frecuencia'    => $data['frecuencia'],
                    'actividad_id'  => $data['actividad_id'],
                ]);
                $citasCreadas++;
            }

            return redirect()->route('admin.citas.listar')
                             ->with('status', $citasCreadas.' citas creadas correctamente (modo masivo).');
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
     * Muestra el formulario para editar una cita existente.
     */
    public function editar(Cita $cita)
    {
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

        // Opcional: filtrar huecos ocupados (si hay reservas/citas en ese horario)
        // ...

        return response()->json($huecos);
    }
}
