<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExpedienteController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $expedientes = Expediente::select('expediente.*')
            ->leftJoin('paciente', 'expediente.Paciente_Id', '=', 'paciente.Id_Paciente')
            ->with(['paciente', 'medico'])
            ->where('expediente.Medico_Id', Auth::id())
            ->when($search, function($query, $search) {
                $query->where(DB::raw("CONCAT(paciente.Nombre, ' ', paciente.Apellido)"), 'like', "%{$search}%")
                      ->orWhere('paciente.Nombre', 'like', "%{$search}%")
                      ->orWhere('paciente.Apellido', 'like', "%{$search}%");
            })
            ->orderBy('expediente.Fecha_Apertura', 'desc')
            ->paginate(10);

        return view('expedientes.index', compact('expedientes', 'search'));
    }

    public function create()
    {
        $pacientes = Paciente::all();
        return view('expedientes.create', compact('pacientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Paciente_Id' => 'required|exists:paciente,Id_Paciente',
            'Estado_Expediente' => 'required|string|in:Activo,Inactivo,Cerrado',
        ]);

        Expediente::create([
            'Paciente_Id' => $request->Paciente_Id,
            'Medico_Id' => Auth::id(),
            'Estado_Expediente' => $request->Estado_Expediente,
            'Fecha_Apertura' => now(),
        ]);

        return redirect()->route('expedientes.index')->with('success', '✅ Expediente creado exitosamente.');
    }

    public function edit($id)
    {
        $expediente = Expediente::with('paciente')->findOrFail($id);
        $pacientes = Paciente::all();
        return view('expedientes.edit', compact('expediente', 'pacientes'));
    }

    public function update(Request $request, $id)
    {
        $expediente = Expediente::findOrFail($id);

        $request->validate([
            'Paciente_Id' => 'required|exists:paciente,Id_Paciente',
            'Estado_Expediente' => 'required|string|in:Activo,Inactivo,Cerrado',
        ]);

        $expediente->update([
            'Paciente_Id' => $request->Paciente_Id,
            'Estado_Expediente' => $request->Estado_Expediente,
        ]);

        return redirect()->route('expedientes.index')->with('success', '✅ Expediente actualizado exitosamente.');
    }

    public function destroy($id)
    {
        $expediente = Expediente::findOrFail($id);
        $expediente->delete();

        return back()->with('success', '🗑️ Expediente eliminado correctamente.');
    }
}
