<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class UsuarioController extends Controller
{
    /**
     * Muestra el perfil del usuario autenticado.
     */
    public function index()
    {
        $usuario = Auth::user();
        return view('usuarios.perfil', compact('usuario'));
    }

    /**
     * Muestra el formulario de edición del perfil.
     */
    public function edit()
    {
        $usuario = Auth::user();
        return view('usuarios.editar', compact('usuario'));
    }

    /**
     * Actualiza los datos del usuario autenticado.
     */
    public function update(Request $request)
    {
        $usuario = Auth::user();

        $request->validate([
            'Nombre' => 'required|string|max:255',
            'Apellido' => 'required|string|max:255',
            'email' => 'required|email|unique:usuario,email,' . $usuario->Id_Usuario . ',Id_Usuario',
            'Especialidad' => 'nullable|string|max:255',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        $usuario->Nombre = $request->Nombre;
        $usuario->Apellido = $request->Apellido;
        $usuario->email = $request->email;
        $usuario->Especialidad = $request->Especialidad;

        // Solo actualizar la contraseña si se ingresó
        if ($request->filled('password')) {
            $usuario->password = Hash::make($request->password);
        }

        $usuario->save();

        return redirect()->route('usuario.perfil')->with('success', 'Perfil actualizado correctamente.');
    }
}
