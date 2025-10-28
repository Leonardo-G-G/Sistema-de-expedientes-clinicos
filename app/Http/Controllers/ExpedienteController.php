<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpedienteController extends Controller
{
    /**
     * 📋 Listado de expedientes
     */
    public function index()
    {
        $expedientes = Expediente::with(['paciente', 'medico'])
            ->orderBy('Fecha_Apertura', 'DESC')
            ->paginate(10);

        return view('expedientes.index', compact('expedientes'));
    }

    /**
     * ➕ Mostrar formulario de creación
     */
    public function create()
    {
        return view('expedientes.create');
    }

    /**
     * 💾 Guardar nuevo expediente
     */
    public function store(Request $request)
    {
        $request->validate([
            'Paciente_Id' => 'required|exists:paciente,Id_Paciente',
        ]);

        $expediente = new Expediente();
        $expediente->Paciente_Id = $request->Paciente_Id;
        $expediente->Medico_Id = Auth::user()->Id_Usuario;
        // Fecha y estado se asignan automáticamente en el modelo
        $expediente->save();

        return redirect()->route('expedientes.index')
                         ->with('success', '✅ Expediente creado exitosamente.');
    }

    /**
     * ✏️ Mostrar formulario de edición (opcional)
     */
    public function edit($Id_Expediente)
    {
        $expediente = Expediente::findOrFail($Id_Expediente);
        return view('expedientes.edit', compact('expediente'));
    }

    /**
     * 🔄 Actualizar expediente (si necesitas editarlo)
     */
    public function update(Request $request, $Id_Expediente)
    {
        $expediente = Expediente::findOrFail($Id_Expediente);

        $request->validate([
            'Paciente_Id' => 'required|exists:paciente,Id_Paciente',
        ]);

        $expediente->Paciente_Id = $request->Paciente_Id;
        // No se cambia Fecha_Apertura ni Estado
        $expediente->save();

        return redirect()->route('expedientes.index')
                         ->with('success', '✅ Expediente actualizado correctamente.');
    }

    /**
     * ❌ Eliminar expediente
     */
    public function destroy($Id_Expediente)
    {
        $expediente = Expediente::findOrFail($Id_Expediente);
        $expediente->delete();

        return redirect()->route('expedientes.index')
                         ->with('success', '🗑️ Expediente eliminado correctamente.');
    }

    /**
     * 🔍 Buscar pacientes por nombre/apellido (para el formulario de expediente)
     */
    public function buscarPacientes(Request $request)
    {
        $query = $request->get('q', '');

        $pacientes = Paciente::where('Nombre', 'like', "%{$query}%")
            ->orWhere('Apellido', 'like', "%{$query}%")
            ->select('Id_Paciente', 'Nombre', 'Apellido')
            ->limit(10)
            ->get();

        return response()->json($pacientes);
    }
}