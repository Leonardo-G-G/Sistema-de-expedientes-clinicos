<?php

namespace App\Http\Controllers;

use App\Models\NotaMedica;
use App\Models\Expediente;
use Illuminate\Http\Request;

class NotaMedicaController extends Controller
{
    /**
     * Listado de notas médicas con búsqueda por paciente y fecha, con paginación.
     */
    public function index(Request $request)
    {
        $search = $request->input('search'); // nombre o apellido
        $fecha  = $request->input('fecha');  // fecha de nota

        $notas = NotaMedica::with('expediente.paciente')
            ->when($search, function($query, $search) {
                $query->whereHas('expediente.paciente', function($q) use ($search) {
                    $q->where('Nombre', 'like', "%{$search}%")
                      ->orWhere('Apellido', 'like', "%{$search}%");
                });
            })
            ->when($fecha, function($query, $fecha) {
                $query->where('Fecha', $fecha);
            })
            ->orderBy('Fecha', 'desc')
            ->paginate(10)
            ->appends($request->all()); // conserva los filtros en la paginación

        return view('notas.index', compact('notas', 'search', 'fecha'));
    }

    /**
     * Formulario para crear una nueva nota médica.
     */
    public function create()
    {
        $expedientes = Expediente::all();
        return view('notas.create', compact('expedientes'));
    }

    /**
     * Guardar nueva nota médica.
     */
    public function store(Request $request)
    {
        $request->validate([
            'Expediente_Id' => 'required|exists:expediente,Id_Expediente',
            'Fecha' => 'required|date',
            'Hora' => 'required',
            'Peso' => 'nullable|numeric',
            'Talla' => 'nullable|numeric',
            'Presion_Arterial' => 'nullable|string|max:20',
            'Frecuencia_Cardiaca' => 'nullable|integer',
            'Impresion_Diagnostica' => 'nullable|string',
            'Tratamiento' => 'nullable|string',
            'Observacion' => 'nullable|string',
        ]);

        NotaMedica::create([
            'Expediente_Id' => $request->Expediente_Id,
            'Fecha' => $request->Fecha,
            'Hora' => $request->Hora,
            'Peso' => $request->Peso,
            'Talla' => $request->Talla,
            'Presion_Arterial' => $request->Presion_Arterial,
            'Frecuencia_Cardiaca' => $request->Frecuencia_Cardiaca,
            'Impresion_Diagnostica' => $request->Impresion_Diagnostica,
            'Tratamiento' => $request->Tratamiento,
            'Observacion' => $request->Observacion,
        ]);

        return back()->with('success', '✅ Nota médica registrada correctamente.');
    }

    /**
     * Mostrar una nota médica específica.
     */
    public function show($id)
    {
        $nota = NotaMedica::with('expediente.paciente')->findOrFail($id);
        return view('notas.show', compact('nota'));
    }

    /**
     * Formulario para editar una nota médica.
     */
    public function edit($id)
    {
        $nota = NotaMedica::findOrFail($id);
        $expedientes = Expediente::all();
        return view('notas.edit', compact('nota', 'expedientes'));
    }

    /**
     * Actualizar nota médica.
     */
    public function update(Request $request, $id)
    {
        $nota = NotaMedica::findOrFail($id);

        $request->validate([
            'Expediente_Id' => 'required|exists:expediente,Id_Expediente',
            'Fecha' => 'required|date',
            'Hora' => 'required',
            'Peso' => 'nullable|numeric',
            'Talla' => 'nullable|numeric',
            'Presion_Arterial' => 'nullable|string|max:20',
            'Frecuencia_Cardiaca' => 'nullable|integer',
            'Impresion_Diagnostica' => 'nullable|string',
            'Tratamiento' => 'nullable|string',
            'Observacion' => 'nullable|string',
        ]);

        $nota->update($request->all());

        return redirect()->route('notas.index')->with('success', '✅ Nota médica actualizada correctamente.');
    }

    /**
     * Eliminar una nota médica.
     */
    public function destroy($id)
    {
        $nota = NotaMedica::findOrFail($id);
        $nota->delete();

        return back()->with('success', '🗑️ Nota médica eliminada correctamente.');
    }
}
