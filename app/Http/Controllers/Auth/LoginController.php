<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login'); // tu vista de login
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'Correo_Electronico' => 'required|email',
            'Contraseña' => 'required|string',
        ]);

        if (Auth::attempt(['Correo_Electronico' => $credentials['Correo_Electronico'], 'password' => $credentials['Contraseña']])) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirección según el rol
            if ($user->Rol_Id == 1) {
                return redirect()->route('admin.dashboard');
            } elseif ($user->Rol_Id == 2) {
                return redirect()->route('medico.dashboard');
            } else {
                return redirect()->route('home');
            }
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
