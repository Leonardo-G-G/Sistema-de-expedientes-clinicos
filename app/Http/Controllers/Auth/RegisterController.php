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

            // Validación correcta
            $request->validate([
                'Nombre' => 'required|string|max:255',
                'Apellido' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:usuario,email',
                'password' => 'required|string|min:6|confirmed',
                'Cedula_Profesional' => 'nullable|string|max:255',
                'Especialidad' => 'nullable|string|max:255',
            ]);

            // Crear usuario con columnas correctas
            Usuario::create([
                'Nombre' => $request->Nombre,
                'Apellido' => $request->Apellido,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'Cedula_Profesional' => $request->Cedula_Profesional,
                'Especialidad' => $request->Especialidad,
            ]);

            return redirect()
                ->route('login')
                ->with('success', 'Registro exitoso. Ya puedes iniciar sesión.');
        }

        catch (ValidationException $e) {
            return back()
                ->withErrors($e->validator)
                ->withInput();
        }

        catch (Exception $e) {
            return back()
                ->with('error', 'Ocurrió un error inesperado. Intenta de nuevo.')
                ->withInput();
        }
    }
}
