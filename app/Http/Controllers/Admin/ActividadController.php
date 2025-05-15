<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Actividad;
use Illuminate\Http\Request;

class ActividadController extends Controller
{
    /**
     * Muestra la lista de actividades.
     */
    public function listar()
    {
        $actividades = Actividad::all();
        return view('Admin.Actividades.index', compact('actividades'));
    }

    /**
     * Muestra el formulario para crear una nueva actividad.
     */
    public function crear()
    {
        return view('Admin.Actividades.crear'); // Para la vista de crear, sin layout
    }

    /**
     * Almacena una nueva actividad en la base de datos.
     */
    public function almacenar(Request $request)
    {
        $datos = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'activo'      => 'required|boolean',
        ]);

        Actividad::create($datos);

        return redirect()->route('admin.actividades.listar')
                         ->with('status', 'Actividad creada correctamente.');
    }

    /**
     * Muestra el formulario para editar una actividad existente.
     */
    public function editar(Actividad $actividad)
    {
        return view('Admin.Actividades.editar', compact('actividad'));
    }

    /**
     * Actualiza la actividad en la base de datos.
     */
    public function actualizar(Request $request, Actividad $actividad)
    {
        $datos = $request->validate([
            'nombre'      => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'activo'      => 'required|boolean',
        ]);

        $actividad->update($datos);

        return redirect()->route('admin.actividades.listar')
                         ->with('status', 'Actividad actualizada correctamente.');
    }

    /**
     * Elimina una actividad.
     */
    public function eliminar(Actividad $actividad)
    {
        $actividad->delete();

        return redirect()->route('admin.actividades.listar')
                         ->with('status', 'Actividad eliminada correctamente.');
    }
}
