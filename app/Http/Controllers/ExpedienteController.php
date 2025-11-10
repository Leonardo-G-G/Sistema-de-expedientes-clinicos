<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ExpedienteController extends Controller
{
    public function index(Request $request)
    {
        $search = trim($request->input('search'));
        $medicoId = Auth::user()->Id_Usuario;

        $expedientes = Expediente::with(['paciente', 'medico'])
            ->where('Medico_Id', $medicoId) // 🔒 Solo expedientes del médico logueado
            ->when($search, fn($query) =>
                $query->whereHas('paciente', fn($q) =>
                    $q->where(fn($sub) =>
                        $sub->where('Nombre', 'like', "%{$search}%")
                            ->orWhere('Apellido', 'like', "%{$search}%")
                            ->orWhereRaw("CONCAT(Nombre, ' ', Apellido) LIKE ?", ["%{$search}%"])
                            ->orWhereRaw("CONCAT(Apellido, ' ', Nombre) LIKE ?", ["%{$search}%"])
                    )
                )
            )
            ->orderByDesc('Fecha_Apertura')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('expedientes.index', compact('expedientes', 'search'));
    }

    public function create()
    {
        $medicoId = Auth::user()->Id_Usuario;

        // 🔒 Solo mostrar pacientes que no tengan expediente o que ya estén bajo este médico
        $pacientes = Paciente::whereDoesntHave('expediente')
            ->orWhereHas('expediente', function ($q) use ($medicoId) {
                $q->where('Medico_Id', $medicoId);
            })
            ->orderBy('Apellido', 'asc')
            ->get();

        return view('expedientes.create', compact('pacientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Paciente_Id' => 'required|exists:paciente,Id_Paciente',
        ], [
            'Paciente_Id.required' => '⚠️ El campo paciente es obligatorio.',
            'Paciente_Id.exists' => '⚠️ Paciente no encontrado.',
        ]);

        $medicoId = Auth::user()->Id_Usuario;

        // 🔒 Verificar si ya existe expediente para ese paciente y médico
        $existe = Expediente::where('Paciente_Id', $request->Paciente_Id)
            ->where('Medico_Id', $medicoId)
            ->exists();

        if ($existe) {
            return back()
                ->withErrors(['Paciente_Id' => '⚠️ Expediente clínico ya existente.'])
                ->withInput();
        }

        $expediente = new Expediente();
        $expediente->Paciente_Id = $request->Paciente_Id;
        $expediente->Medico_Id = $medicoId;
        $expediente->Estado_Expediente = 'Activo';
        $expediente->Fecha_Apertura = now()->toDateString();
        $expediente->save();

        return redirect()->route('expedientes.index')
                         ->with('success', '✅ Expediente creado exitosamente.');
    }

    public function edit($Id_Expediente)
    {
        $expediente = Expediente::where('Medico_Id', Auth::user()->Id_Usuario)
            ->findOrFail($Id_Expediente);

        $pacientes = Paciente::orderBy('Apellido', 'asc')->get();

        return view('expedientes.edit', compact('expediente', 'pacientes'));
    }

    public function update(Request $request, $Id_Expediente)
    {
        $expediente = Expediente::where('Medico_Id', Auth::user()->Id_Usuario)
            ->findOrFail($Id_Expediente);

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

    public function destroy($Id_Expediente)
    {
        $expediente = Expediente::where('Medico_Id', Auth::user()->Id_Usuario)
            ->findOrFail($Id_Expediente);

        $expediente->delete();

        return redirect()->route('expedientes.index')
                         ->with('success', '🗑️ Expediente eliminado correctamente.');
    }

    public function buscarExpedientes(Request $request)
    {
        $query = trim($request->get('q', ''));
        $medicoId = Auth::user()->Id_Usuario;

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $expedientes = Expediente::with('paciente')
            ->where('Medico_Id', $medicoId)
            ->whereHas('paciente', fn($q) =>
                $q->where(fn($sub) =>
                    $sub->where('Nombre', 'like', "%{$query}%")
                        ->orWhere('Apellido', 'like', "%{$query}%")
                        ->orWhereRaw("CONCAT(Nombre, ' ', Apellido) LIKE ?", ["%{$query}%"])
                        ->orWhereRaw("CONCAT(Apellido, ' ', Nombre) LIKE ?", ["%{$query}%"])
                )
            )
            ->limit(10)
            ->get();

        return response()->json(
            $expedientes->map(fn($e) => [
                'Id_Expediente' => $e->Id_Expediente,
                'Nombre' => $e->paciente->Nombre ?? '',
                'Apellido' => $e->paciente->Apellido ?? '',
                'Fecha_Apertura' => optional($e->Fecha_Apertura)->format('Y-m-d'),
            ])
        );
    }

    public function buscarPacientes(Request $request)
    {
        $query = trim($request->get('q', ''));
        $medicoId = Auth::user()->Id_Usuario;

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        // 🔒 Buscar solo pacientes sin expediente o del mismo médico
        $pacientes = Paciente::where(fn($q) =>
                $q->where('Nombre', 'like', "%{$query}%")
                  ->orWhere('Apellido', 'like', "%{$query}%")
                  ->orWhereRaw("CONCAT(Nombre, ' ', Apellido) LIKE ?", ["%{$query}%"])
                  ->orWhereRaw("CONCAT(Apellido, ' ', Nombre) LIKE ?", ["%{$query}%"])
            )
            ->where(function ($q) use ($medicoId) {
                $q->whereDoesntHave('expediente')
                  ->orWhereHas('expediente', fn($sub) => $sub->where('Medico_Id', $medicoId));
            })
            ->limit(10)
            ->get(['Id_Paciente', 'Nombre', 'Apellido']);

        return response()->json($pacientes);
    }
}
