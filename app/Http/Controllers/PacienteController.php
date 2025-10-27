<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;

class PacienteController extends Controller
{
    /**
     * 📋 Listado de pacientes con buscador avanzado
     */
    public function index(Request $request)
    {
        $search = $request->input('search');

        $pacientes = Paciente::when($search, function ($query, $search) {
            $query->where('Nombre', 'like', "%{$search}%")
                  ->orWhere('Apellido', 'like', "%{$search}%")
                  ->orWhereRaw("CONCAT(Nombre, ' ', Apellido) LIKE ?", ["%{$search}%"])
                  ->orWhere('Telefono', 'like', "%{$search}%")
                  ->orWhere('Lugar_Origen', 'like', "%{$search}%");
        })
        ->orderBy('Id_Paciente', 'DESC')
        ->paginate(10);

        return view('pacientes.index', compact('pacientes'));
    }

    /**
     * ➕ Mostrar formulario de creación
     */
    public function create()
    {
        return view('pacientes.create');
    }

    /**
     * 💾 Guardar nuevo paciente
     */
    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:100',
            'Apellido' => 'required|string|max:100',
            'Sexo' => 'nullable|string|max:10',
            'Telefono' => 'nullable|string|max:15',
            'Lugar_Origen' => 'nullable|string|max:150',
        ]);

        Paciente::create($request->all());

        return redirect()->route('pacientes.index')
                         ->with('success', '✅ Paciente registrado exitosamente.');
    }

    /**
     * ✏️ Editar paciente existente
     */
    public function edit($Id_Paciente)
    {
        $paciente = Paciente::findOrFail($Id_Paciente);
        return view('pacientes.edit', compact('paciente'));
    }

    /**
     * 🔄 Actualizar datos de paciente
     */
    public function update(Request $request, $Id_Paciente)
    {
        $paciente = Paciente::findOrFail($Id_Paciente);

        $request->validate([
            'Nombre' => 'required|string|max:100',
            'Apellido' => 'required|string|max:100',
            'Sexo' => 'nullable|string|max:10',
            'Telefono' => 'nullable|string|max:15',
            'Lugar_Origen' => 'nullable|string|max:150',
        ]);

        $paciente->update($request->all());

        return redirect()->route('pacientes.index')
                         ->with('success', '✅ Datos del paciente actualizados correctamente.');
    }

    /**
     * ❌ Eliminar paciente
     */
    public function destroy($Id_Paciente)
    {
        $paciente = Paciente::findOrFail($Id_Paciente);
        $paciente->delete();

        return redirect()->route('pacientes.index')
                         ->with('success', '🗑️ Paciente eliminado correctamente.');
    }
}
