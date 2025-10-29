<?php

namespace App\Http\Controllers;

use App\Models\NotaMedica;
use App\Models\HistoriaClinica;
use Illuminate\Http\Request;

class NotaMedicaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $fecha  = $request->input('fecha');

        $notas = NotaMedica::with('historiaClinica.expediente.paciente')
            ->when($search, function ($query, $search) {
                $query->whereHas('historiaClinica.expediente.paciente', function ($q) use ($search) {
                    $q->whereRaw("CONCAT(Nombre, ' ', Apellido) LIKE ?", ["%{$search}%"])
                        ->orWhereRaw("CONCAT(Apellido, ' ', Nombre) LIKE ?", ["%{$search}%"]);
                });
            })
            ->when($fecha, function ($query, $fecha) {
                $query->whereDate('Fecha', $fecha);
            })
            ->orderBy('Fecha', 'desc')
            ->paginate(10)
            ->appends($request->all());

        return view('notas.index', compact('notas', 'search', 'fecha'));
    }

    public function create($id = null)
    {
        $historia = $id ? HistoriaClinica::with('expediente.paciente')->findOrFail($id) : null;
        $historias = HistoriaClinica::with('expediente.paciente')->get();

        return view('notas.create', compact('historia', 'historias'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'Historia_Id' => 'required|exists:historia_clinica,Id_Historia',
            'Peso' => 'nullable|numeric',
            'Talla' => 'nullable|numeric',
            'Presion_Arterial' => 'nullable|string|max:20',
            'Frecuencia_Cardiaca' => 'nullable|integer',
            'Impresion_Diagnostica' => 'nullable|string',
            'Tratamiento' => 'nullable|string',
            'Observacion' => 'nullable|string',
        ]);

        NotaMedica::create(array_merge(
            $request->only([
                'Historia_Id',
                'Peso',
                'Talla',
                'Presion_Arterial',
                'Frecuencia_Cardiaca',
                'Impresion_Diagnostica',
                'Tratamiento',
                'Observacion',
            ]),
            [
                'Fecha' => now()->toDateString(),
                'Hora'  => now()->format('H:i:s'),
            ]
        ));

        return redirect()->route('notas.index')->with('success', '✅ Nota médica registrada correctamente.');
    }

    public function show($id)
{
    $nota = NotaMedica::with('historiaClinica.expediente.paciente')->findOrFail($id);
    $historia = $nota->historiaClinica;

    return view('notas.show', compact('nota', 'historia'));
}


    public function edit($id)
    {
        $nota = NotaMedica::findOrFail($id);
        $historias = HistoriaClinica::with('expediente.paciente')->get();

        return view('notas.edit', compact('nota', 'historias'));
    }

    public function update(Request $request, $id)
    {
        $nota = NotaMedica::findOrFail($id);

        $request->validate([
            'Historia_Id' => 'required|exists:historia_clinica,Id_Historia',
            'Peso' => 'nullable|numeric',
            'Talla' => 'nullable|numeric',
            'Presion_Arterial' => 'nullable|string|max:20',
            'Frecuencia_Cardiaca' => 'nullable|integer',
            'Impresion_Diagnostica' => 'nullable|string',
            'Tratamiento' => 'nullable|string',
            'Observacion' => 'nullable|string',
        ]);

        $nota->update(array_merge(
            $request->only([
                'Historia_Id',
                'Peso',
                'Talla',
                'Presion_Arterial',
                'Frecuencia_Cardiaca',
                'Impresion_Diagnostica',
                'Tratamiento',
                'Observacion',
            ]),
            [
                'Fecha' => now()->toDateString(),
                'Hora'  => now()->format('H:i:s'),
            ]
        ));

        return redirect()->route('notas.index')->with('success', '✅ Nota médica actualizada correctamente.');
    }
    public function buscarHistorias(Request $request)
{
    $q = $request->get('q');
    $historias = HistoriaClinica::with('expediente.paciente')
        ->whereHas('expediente.paciente', function($query) use ($q) {
            $query->where('Nombre', 'like', "%{$q}%")
                  ->orWhere('Apellido', 'like', "%{$q}%");
        })
        ->get()
        ->map(function($h) {
            return [
                'Id_Historia' => $h->Id_Historia,
                'Nombre' => $h->expediente->paciente->Nombre,
                'Apellido' => $h->expediente->paciente->Apellido
            ];
        });
    return response()->json($historias);
}


    public function destroy($id)
    {
        NotaMedica::findOrFail($id)->delete();

        return back()->with('success', '🗑️ Nota médica eliminada correctamente.');
    }
}
