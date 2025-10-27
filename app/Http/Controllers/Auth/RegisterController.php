<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        try {
            // Validar campos
            $request->validate([
                'Nombre' => 'required|string|max:255',
                'Apellido' => 'required|string|max:255',
                'Correo_Electronico' => 'required|string|email|max:255|unique:usuario,Correo_Electronico',
                'Contraseña' => 'required|string|min:6|confirmed',
                'Cedula_Profesional' => 'nullable|string|max:255',
                'Especialidad' => 'nullable|string|max:255',
            ]);

            // Crear usuario
            Usuario::create([
                'Nombre' => $request->Nombre,
                'Apellido' => $request->Apellido,
                'Correo_Electronico' => $request->Correo_Electronico,
                'Contraseña' => Hash::make($request->Contraseña),
                'Cedula_Profesional' => $request->Cedula_Profesional,
                'Especialidad' => $request->Especialidad,
            ]);

            return redirect()->route('login')->with('success', '✅ Registro exitoso. Ya puedes iniciar sesión.');
        } catch (Exception $e) {
            return back()->with('error', '❌ Error al registrar el usuario: ' . $e->getMessage());
        }
    }
}
