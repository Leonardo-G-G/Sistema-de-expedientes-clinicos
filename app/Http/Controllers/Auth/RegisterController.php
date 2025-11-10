<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Usuario;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
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
            // ✅ Validación con mensajes personalizados
            $request->validate([
                'Nombre' => 'required|string|max:255',
                'Apellido' => 'required|string|max:255',
                'Correo_Electronico' => 'required|string|email|max:255|unique:usuario,Correo_Electronico',
                'Contraseña' => 'required|string|min:6|confirmed',
                'Cedula_Profesional' => 'nullable|string|max:255',
                'Especialidad' => 'nullable|string|max:255',
            ], [
                'Nombre.required' => '⚠️ El nombre es obligatorio.',
                'Apellido.required' => '⚠️ El apellido es obligatorio.',
                'Correo_Electronico.required' => '⚠️ El correo electrónico es obligatorio.',
                'Correo_Electronico.email' => '⚠️ Debes ingresar un correo electrónico válido.',
                'Correo_Electronico.unique' => '⚠️ El correo electrónico ya está registrado.',
                'Contraseña.required' => '⚠️ La contraseña es obligatoria.',
                'Contraseña.min' => '⚠️ La contraseña debe tener al menos 6 caracteres.',
                'Contraseña.confirmed' => '⚠️ Las contraseñas no coinciden.',
            ]);

            // ✅ Crear usuario si pasa la validación
            Usuario::create([
                'Nombre' => $request->Nombre,
                'Apellido' => $request->Apellido,
                'Correo_Electronico' => $request->Correo_Electronico,
                'Contraseña' => Hash::make($request->Contraseña),
                'Cedula_Profesional' => $request->Cedula_Profesional,
                'Especialidad' => $request->Especialidad,
            ]);

            // ✅ Redirigir con mensaje de éxito
            return redirect()
                ->route('login')
                ->with('success', ' Registro exitoso. Ya puedes iniciar sesión.');
        } 
        catch (ValidationException $e) {
            // ⚠️ Devuelve los errores de validación normalmente
            return back()
                ->withErrors($e->validator)
                ->withInput();
        }
        catch (Exception $e) {
            // ⚠️ Maneja cualquier otro error inesperado
            return back()
                ->with('error', '❌ Ocurrió un error inesperado al registrar el usuario. Intenta de nuevo.')
                ->withInput();
        }
    }
}
