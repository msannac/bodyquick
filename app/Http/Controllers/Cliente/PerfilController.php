<?php


namespace App\Http\Controllers\Cliente;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('Cliente.Perfil.edit', compact('user'));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user || !$user instanceof \App\Models\User) {
            if ($request->ajax()) {
                return response()->json(['error' => 'Debes iniciar sesión para actualizar tu perfil.'], 401);
            }
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para actualizar tu perfil.');
        }

        // Validar todos los campos del formulario de perfil de cliente
        $rules = [
            'name'          => 'required|string|max:255',
            'apellidos'     => 'nullable|string|max:255',
            'dni'           => 'nullable|string|max:20',
            'telefono'      => 'nullable|string|max:30',
            // No se permite modificar el email
            'profile_photo' => 'nullable|image|max:2048',
        ];
        // Si el usuario quiere cambiar la contraseña, obligar a confirmar
        if ($request->filled('password')) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }
        $data = $request->validate($rules);

        $user->name = $data['name'];
        $user->apellidos = $data['apellidos'] ?? $user->apellidos;
        $user->dni = $data['dni'] ?? $user->dni;
        $user->telefono = $data['telefono'] ?? $user->telefono;

        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('images/perfil', 'public');
            $user->profile_photo_path = $path;
        }

        $user->save();

        // Si es AJAX, responder con JSON para que el modal se cierre correctamente
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Perfil actualizado correctamente.']);
        }

        // Si no es AJAX, redirigir normalmente
        return redirect()->route('cliente.perfil.editar')->with('status', 'Perfil actualizado correctamente.');
    }
}