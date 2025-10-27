<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    // 📋 Listado de pacientes con buscador
    public function index(Request $request)
    {
        $query = $request->input('search');

        $pacientes = Paciente::when($query, function ($q) use ($query) {
            $q->where('Nombre', 'like', "%{$query}%")
              ->orWhere('Apellido', 'like', "%{$query}%");
        })
        ->orderBy('Id_Paciente', 'DESC')
        ->paginate(10);

        return view('pacientes.index', compact('pacientes'));
    }

    // ➕ Crear nuevo paciente
    public function create()
    {
        return view('pacientes.create');
    }

    // 💾 Guardar paciente
    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:100',
            'Apellido' => 'required|string|max:100',
        ]);

        Paciente::create($request->all());
        return redirect()->route('pacientes.index')->with('success', '✅ Paciente registrado exitosamente.');
    }

    // ✏️ Editar paciente
    public function edit($Id_Paciente)
    {
        $paciente = Paciente::findOrFail($Id_Paciente);
        return view('pacientes.edit', compact('paciente'));
    }

    // 🔄 Actualizar paciente
    public function update(Request $request, $Id_Paciente)
    {
        $paciente = Paciente::findOrFail($Id_Paciente);
        $paciente->update($request->all());
        return redirect()->route('pacientes.index')->with('success', '✅ Datos del paciente actualizados.');
    }

    // ❌ Eliminar paciente
    public function destroy($Id_Paciente)
    {
        $paciente = Paciente::findOrFail($Id_Paciente);
        $paciente->delete();
        return redirect()->route('pacientes.index')->with('success', '🗑️ Paciente eliminado correctamente.');
    }
}
