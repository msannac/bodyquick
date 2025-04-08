<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeMail;

class AdminController extends Controller
{
    public function createUser(Request $request) {
        $password = $request->password; // Capturamos la contraseña en texto plano

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($password),
            'role'     => 'cliente',
        ]);

        Mail::to($user->email)->send(new WelcomeMail($user, $password));
        
        return response()->json(['message' => 'Usuario creado y credenciales enviadas']);
    }
}
