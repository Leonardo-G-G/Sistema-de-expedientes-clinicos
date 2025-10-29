<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpedienteController extends Controller
{
    /**
     * 📋 Listado de expedientes con buscador avanzado
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search'));

        $expedientes = Expediente::with(['paciente', 'medico'])
            ->when($search, function ($query) use ($search) {
                $query->whereHas('paciente', function ($q) use ($search) {
                    $q->where(function ($sub) use ($search) {
                        $sub->where('Nombre', 'like', "%{$search}%")
                            ->orWhere('Apellido', 'like', "%{$search}%")
                            ->orWhereRaw("CONCAT(Nombre, ' ', Apellido) LIKE ?", ["%{$search}%"])
                            ->orWhereRaw("CONCAT(Apellido, ' ', Nombre) LIKE ?", ["%{$search}%"]);
                    });
                });
            })
            ->orderByDesc('Fecha_Apertura')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('expedientes.index', compact('expedientes', 'search'));
    }

    /**
     * ➕ Mostrar formulario de creación
     */
    public function create()
    {
        $pacientes = Paciente::orderBy('Apellido', 'asc')->get();
        return view('expedientes.create', compact('pacientes'));
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
        $expediente->Medico_Id = Auth::user()->Id_Usuario ?? null;
        $expediente->Estado_Expediente = 'Activo';
        $expediente->Fecha_Apertura = now();
        $expediente->save();

        return redirect()->route('expedientes.index')
                         ->with('success', '✅ Expediente creado exitosamente.');
    }

    /**
     * ✏️ Mostrar formulario de edición
     */
    public function edit($Id_Expediente)
    {
        $expediente = Expediente::findOrFail($Id_Expediente);
        $pacientes = Paciente::orderBy('Apellido', 'asc')->get();

        return view('expedientes.edit', compact('expediente', 'pacientes'));
    }

    /**
     * 🔄 Actualizar expediente
     */
    public function update(Request $request, $Id_Expediente)
    {
        $expediente = Expediente::findOrFail($Id_Expediente);

        $request->validate([
            'Paciente_Id' => 'required|exists:paciente,Id_Paciente',
            'Estado_Expediente' => 'required|in:Activo,Inactivo,Cerrado',
        ]);

        $expediente->Paciente_Id = $request->Paciente_Id;
        $expediente->Estado_Expediente = $request->Estado_Expediente;
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
     * 🔍 Buscar expedientes por nombre o apellido del paciente (para autocompletar)
     */
    public function buscarExpedientes(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $expedientes = Expediente::with('paciente')
            ->whereHas('paciente', function ($q) use ($query) {
                $q->where('Nombre', 'like', "%{$query}%")
                  ->orWhere('Apellido', 'like', "%{$query}%")
                  ->orWhereRaw("CONCAT(Nombre, ' ', Apellido) LIKE ?", ["%{$query}%"])
                  ->orWhereRaw("CONCAT(Apellido, ' ', Nombre) LIKE ?", ["%{$query}%"]);
            })
            ->get();

        // 🔹 Formato compatible con el frontend
        $resultados = $expedientes->map(function ($e) {
            return [
                'Id_Expediente' => $e->Id_Expediente,
                'Nombre' => $e->paciente->Nombre ?? '',
                'Apellido' => $e->paciente->Apellido ?? '',
                'Fecha_Apertura' => $e->Fecha_Apertura
                    ? date('Y-m-d', strtotime($e->Fecha_Apertura))
                    : '',
            ];
        });

        return response()->json($resultados);
    }
}
