<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Exception;

class RegisterController extends Controller
{
    /**
     * Muestra el formulario de registro.
     */
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    /**
     * Procesa el registro del usuario.
     */
    public function register(Request $request)
    {
        try {
            // ✅ Validación de los campos del formulario
            $request->validate([
                'Nombre' => 'required|string|max:255',
                'Apellido' => 'required|string|max:255',
                'Correo_Electronico' => 'required|string|email|max:255|unique:usuario',
                'Contraseña' => 'required|string|min:6|confirmed',
                'Rol_Id' => 'required|integer',
            ]);

            // ✅ Crear el nuevo usuario
            Usuario::create([
                'Nombre' => $request->Nombre,
                'Apellido' => $request->Apellido,
                'Correo_Electronico' => $request->Correo_Electronico,
                'Contraseña' => Hash::make($request->Contraseña),
                'Rol_Id' => $request->Rol_Id,
                'Cedula_Profesional' => $request->Cedula_Profesional,
                'Especialidad' => $request->Especialidad,
            ]);

          
            // Solo mostrar mensaje en la misma vista
            return redirect()->back()->with('success', '✅ Registro exitoso. Ya puedes iniciar sesión.');

        } catch (Exception $e) {
            // ❌ Si ocurre algún error, lo mostramos en pantalla
            return redirect()->back()->with('error', '❌ Error al registrar el usuario: ' . $e->getMessage());
        }
    }
}
