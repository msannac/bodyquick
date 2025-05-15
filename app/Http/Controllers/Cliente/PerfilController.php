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
        
        // Aquí suponemos que el correo no puede modificarse por el cliente
        $data = $request->validate([
            'name'          => 'required|string|max:255',
            // No se permite modificar el email
            'password'      => 'nullable|string|min:8|confirmed',
            'profile_photo' => 'nullable|image|max:2048',
        ]);
        
        $user->name = $data['name'];
        
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }
        
        if ($request->hasFile('profile_photo')) {
            $path = $request->file('profile_photo')->store('images/perfil', 'public');
            $user->profile_photo_path = $path;
        }
        
        $user->save();
        
        return redirect()->route('cliente.perfil.editar')->with('status', 'Perfil actualizado correctamente.');
    }
}