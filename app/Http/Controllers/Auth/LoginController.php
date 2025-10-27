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
        // Validamos los datos
        $credentials = $request->validate([
            'Correo_Electronico' => 'required|email',
            'Contraseña' => 'required|string',
        ]);

        // Intentamos autenticar
        if (Auth::attempt([
            'Correo_Electronico' => $credentials['Correo_Electronico'],
            'password' => $credentials['Contraseña']
        ])) {
            $request->session()->regenerate();

            return redirect()->route('dashboard') // Cambia a tu ruta principal
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
