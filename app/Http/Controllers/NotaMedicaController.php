<?php

namespace App\Http\Controllers;

use App\Models\NotaMedica;
use App\Models\Expediente;
use Illuminate\Http\Request;

class NotaMedicaController extends Controller
{
    public function create()
    {
        // Trae todos los expedientes disponibles
        $expedientes = Expediente::all();
        return view('admin.notas.create', compact('expedientes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Expediente_Id' => 'required|exists:expediente,Id_Expediente',
            'Fecha' => 'required|date',
            'Hora' => 'required',
            'Diagnostico' => 'required|string|max:255',
            'Tratamiento' => 'required|string|max:255',
            'Pronostico' => 'nullable|string|max:255',
            'Observacion' => 'nullable|string|max:500'
        ]);

        NotaMedica::create($request->all());

        return back()->with('success', '✅ Nota médica registrada correctamente.');
    }
}
