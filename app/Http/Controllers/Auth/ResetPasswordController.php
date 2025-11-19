<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    /**
     * Mostrar formulario de reset
     */
    public function showResetForm(Request $request, $token = null)
    {
        return view('auth.passwords.reset')->with([
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Procesar restablecimiento de contraseña
     */
    public function reset(Request $request)
    {
        // Validación
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|confirmed|min:6',
            'token' => 'required',
        ]);

        // Hacer reset
        $response = Password::broker('usuarios')->reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        return $response === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($response))
            : back()->withErrors(['email' => __($response)]);
    }
}
