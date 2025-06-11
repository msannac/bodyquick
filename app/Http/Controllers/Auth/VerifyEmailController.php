<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class VerifyEmailController extends Controller
{
    /**
     * Maneja la verificación del correo electrónico.
     */
    public function verify(EmailVerificationRequest $request)
    {
        if ($request->user()->hasVerifiedEmail()) {
            return $this->redirectUser($request);
        }

        if ($request->user()->markEmailAsVerified()) {
            // Aquí puedes lanzar un evento si lo necesitas
        }

        return $this->redirectUser($request);
    }

    /**
     * Redirige según el tipo de usuario.
     */
    protected function redirectUser(Request $request)
    {
        if ($request->user()->is_admin) {
            return redirect('/admin/dashboard')->with('status', 'Correo verificado correctamente.');
        } else {
            return redirect('/cliente/reservas')->with('status', 'Correo verificado correctamente.');
        }
    }
}