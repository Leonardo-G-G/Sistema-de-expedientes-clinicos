<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ForgotPasswordController extends Controller
{
    /**
     * Mostrar formulario de solicitud
     */
    public function showLinkRequestForm()
    {
        return view('auth.passwords.email');
    }

    /**
     * Enviar enlace de restablecimiento
     */
    public function sendResetLinkEmail(Request $request)
    {
        // Validación
        $request->validate([
            'email' => 'required|email',
        ]);

        // Laravel usa el campo "email"
        $response = Password::broker('usuarios')->sendResetLink(
            $request->only('email')
        );

        return $response === Password::RESET_LINK_SENT
            ? back()->with('status', __($response))
            : back()->withErrors(['email' => __($response)]);
    }
}
