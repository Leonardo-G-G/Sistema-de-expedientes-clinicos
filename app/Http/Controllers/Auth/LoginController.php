<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validar datos
        $credentials = $request->validate([
            'Correo_Electronico' => 'required|email',
            'Contraseña' => 'required|string',
        ]);

        // Intentar autenticación
        if (Auth::attempt([
            'Correo_Electronico' => $credentials['Correo_Electronico'],
            'password' => $credentials['Contraseña']
        ])) {
            $request->session()->regenerate();

            // ✅ Redirige al dashboard general
            return redirect()->route('dashboard')
                ->with('success', 'Bienvenido de nuevo.');
        }

        return back()->withErrors([
            'Correo_Electronico' => 'Las credenciales no coinciden con nuestros registros.',
        ])->onlyInput('Correo_Electronico');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
