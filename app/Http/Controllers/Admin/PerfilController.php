<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('Admin.Perfil.edit', compact('user'));
    }
    
    public function update(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para actualizar tu perfil.');
        }

        if (!$user instanceof \App\Models\User) {
            throw new \Exception('El usuario autenticado no es válido.');
        }
        
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            'apellidos'     => 'nullable|string|max:255',
            'dni'           => "nullable|string|max:20|unique:users,dni,{$user->id}",
            'telefono'      => 'nullable|string|max:15',
            'email'         => "required|email|max:255|unique:users,email,{$user->id}",
            'password'      => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|max:2048',
        ]);
        
        $user->name      = $data['name'];
        $user->apellidos = $data['apellidos'] ?? $user->apellidos;
        $user->dni       = $data['dni'] ?? $user->dni;
        $user->telefono  = $data['telefono'] ?? $user->telefono;
        $user->email     = $data['email'];
        
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('images/perfil', 'public');
            $user->profile_photo_path = $path;
        }
        
        $user->save();
        
        return redirect()->route('admin.perfil.editar')->with('status', 'Perfil actualizado correctamente.');
    }
}