<?php

namespace App\Http\Controllers;

use App\Models\Expediente;
use App\Models\Paciente;
use App\Models\Usuario;
use Illuminate\Http\Request;

class ExpedienteController extends Controller
{
    public function create()
    {
        $pacientes = Paciente::all();
        $medicos = Usuario::where('Rol_Id', 2)->get(); // Solo médicos
        return view('admin.expedientes.create', compact('pacientes', 'medicos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Paciente_Id' => 'required|exists:paciente,Id_Paciente',
            'Medico_Id' => 'required|exists:usuario,Id_Usuario',
            'Estado_Expediente' => 'required|string|max:50',
        ]);

        Expediente::create([
            'Paciente_Id' => $request->Paciente_Id,
            'Medico_Id' => $request->Medico_Id,
            'Estado_Expediente' => $request->Estado_Expediente,
            'Fecha_Creacion' => now(),
        ]);

        return back()->with('success', '✅ Expediente creado exitosamente.');
    }
}
