<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Entrenador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EntrenadorController extends Controller
{
    /**
     * Muestra la lista de entrenadores.
     */
    public function listar()
    {
        $entrenadores = Entrenador::all();
        return view('Admin.Entrenadores.index', compact('entrenadores'));
    }

    /**
     * Muestra el formulario para crear un nuevo entrenador.
     */
    public function crear()
    {
        return view('Admin.Entrenadores.crear');
    }

    /**
     * Almacena un nuevo entrenador en la base de datos.
     */
    public function almacenar(Request $request)
    {
        $datos = $request->validate([
            'nombre'             => 'required|string|max:255',
            'apellidos'          => 'required|string|max:255',
            'dni'                => 'required|string|max:50|unique:entrenadores,dni',
            'telefono'           => 'nullable|string|max:50',
            'especialidad'       => 'required|in:entrenamiento funcional,electroestimulación,readaptacion de lesiones',
            'profile_photo_path' => 'nullable|image|max:2048', // Validar imagen
        ]);

        if($request->hasFile('profile_photo_path')){
            $ruta = $request->file('profile_photo_path')->store('entrenadores','public');
            $datos['profile_photo_path'] = $ruta;
        }

        Entrenador::create($datos);

        return redirect()->route('admin.entrenadores.listar')
                         ->with('status', 'Entrenador creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un entrenador.
     */
    public function editar(Entrenador $entrenador)
    {
        return view('Admin.Entrenadores.editar', compact('entrenador'));
    }

    /**
     * Actualiza los datos del entrenador en la base de datos.
     */
    public function actualizar(Request $request, Entrenador $entrenador)
    {
        $datos = $request->validate([
            'nombre'             => 'required|string|max:255',
            'apellidos'          => 'required|string|max:255',
            'dni'                => "required|string|max:50|unique:entrenadores,dni,{$entrenador->id}",
            'telefono'           => 'nullable|string|max:50',
            'especialidad'       => 'required|in:entrenamiento funcional,electroestimulación,readaptacion de lesiones',
            'profile_photo_path' => 'nullable|image|max:2048',
        ]);

        if($request->hasFile('profile_photo_path'))
        {
            // Opcional: Eliminar la imagen anterior si existe.
            if($entrenador->profile_photo_path) {
                Storage::disk('public')->delete($entrenador->profile_photo_path);
            }
            $ruta = $request->file('profile_photo_path')->store('entrenadores','public');
            $datos['profile_photo_path'] = $ruta;
        }

        $entrenador->update($datos);

        return redirect()->route('admin.entrenadores.listar')
                         ->with('status', 'Entrenador actualizado correctamente.');
    }

    /**
     * Elimina un entrenador.
     */
    public function eliminar(Entrenador $entrenador)
    {
        $entrenador->delete();

        return redirect()->route('admin.entrenadores.listar')
                         ->with('status', 'Entrenador eliminado correctamente.');
    }
}
