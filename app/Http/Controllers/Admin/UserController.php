<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Muestra el formulario para registrar un nuevo usuario.
     */
    public function create()
    {
        return view('Admin.createUser');
    }

    /**
     * Procesa el registro del nuevo usuario.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'apellidos' => 'nullable|string|max:255', // Validación para apellidos
            'dni'      => 'nullable|string|max:20|unique:users', // Validación para DNI
            'telefono' => 'nullable|string|max:15', // Validación para teléfono
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Crear el usuario con los nuevos campos
        User::create([
            'name'     => $validated['name'],
            'apellidos' => $validated['apellidos'] ?? null,
            'dni'      => $validated['dni'] ?? null,
            'telefono' => $validated['telefono'] ?? null,
            'email'    => $validated['email'],
            'password' => Hash::make($validated['password']),
            'is_admin' => false,
        ]);

        return redirect()->route('admin.users.create')->with('status', 'Usuario creado correctamente.');
    }

    /**
     * Muestra la lista de clientes (usuarios que no son admin), con filtro por nombre si se solicita.
     */
    public function listar(Request $request)
    {
        $query = User::where('is_admin', false);
        if ($request->filled('cliente') && strlen($request->cliente) >= 3) {
            $letras = mb_str_split(strtolower($request->cliente));
            // Primer filtro: al menos una letra en el nombre o apellidos (para reducir resultados)
            foreach ($letras as $letra) {
                $query->where(function($q) use ($letra) {
                    $q->whereRaw('LOWER(name) LIKE ?', ["%$letra%"])
                      ->orWhereRaw('LOWER(apellidos) LIKE ?', ["%$letra%"]);
                });
            }
            $clientes = $query->get();
            // Segundo filtro: todas las letras presentes en el nombre o apellidos (en cualquier orden)
            $clientes = $clientes->filter(function($cliente) use ($letras) {
                $nombre = strtolower($cliente->name . ' ' . $cliente->apellidos);
                foreach ($letras as $letra) {
                    if (strpos($nombre, $letra) === false) {
                        return false;
                    }
                }
                return true;
            });
            $clientes = $clientes->values(); // Reindexar colección
        } else {
            $clientes = $query->get();
        }

        if ($request->ajax()) {
            return view('Admin.Clientes.partials.tbody', compact('clientes'))->render();
        }
        return view('Admin.Clientes.index', compact('clientes'));
    }

    /**
     * Muestra el formulario para crear un nuevo cliente.
     */
    public function crear()
    {
        return view('Admin.Clientes.crear');
    }

    /**
     * Almacena un nuevo cliente en la base de datos.
     */
    public function almacenar(Request $request)
    {
        $datos = $request->validate([
            'name'     => 'required|string|max:255',
            'apellidos' => 'nullable|string|max:255',
            'dni'      => 'nullable|string|max:20|unique:users',
            'telefono' => 'nullable|string|max:15',
            'email'    => 'required|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name'     => $datos['name'],
            'apellidos' => $datos['apellidos'] ?? null,
            'dni'      => $datos['dni'] ?? null,
            'telefono' => $datos['telefono'] ?? null,
            'email'    => $datos['email'],
            'password' => Hash::make($datos['password']),
            'is_admin' => false,
        ]);

        return redirect()->route('admin.clientes.listar')->with('status', 'Cliente creado correctamente.');
    }

    /**
     * Muestra el formulario para editar un cliente existente.
     */
    public function editar(User $cliente)
    {
        return view('Admin.Clientes.editar', compact('cliente'));
    }

    /**
     * Actualiza el cliente en la base de datos.
     */
    public function actualizar(Request $request, User $cliente)
    {
        $datos = $request->validate([
            'name'     => 'required|string|max:255',
            'apellidos' => 'nullable|string|max:255',
            'dni'      => "nullable|string|max:20|unique:users,dni,{$cliente->id}",
            'telefono' => 'nullable|string|max:15',
            'email'    => "required|email|max:255|unique:users,email,{$cliente->id}",
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $actualizar = [
            'name'      => $datos['name'],
            'apellidos' => $datos['apellidos'] ?? $cliente->apellidos,
            'dni'       => $datos['dni'] ?? $cliente->dni,
            'telefono'  => $datos['telefono'] ?? $cliente->telefono,
            'email'     => $datos['email'],
        ];

        if (!empty($datos['password'])) {
            $actualizar['password'] = Hash::make($datos['password']);
        }

        $cliente->update($actualizar);

        return redirect()->route('admin.clientes.listar')->with('status', 'Cliente actualizado correctamente.');
    }

    /**
     * Elimina un cliente.
     */
    public function eliminar(User $cliente)
    {
        $cliente->delete();

        return redirect()->route('admin.clientes.listar')->with('status', 'Cliente eliminado correctamente.');
    }
}