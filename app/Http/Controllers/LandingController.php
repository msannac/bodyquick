<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LandingController extends Controller
{
    /**
     * Muestra la landing o redirige según el usuario autenticado.
     */
    public function index(Request $request)
    {
        if (Auth::check()) {
            if (Auth::user()->is_admin) {
                return redirect()->route('admin.dashboard');
            } else {
                return redirect()->route('cliente.reservas.index');
            }
        }
        return view('landing');
    }
}
