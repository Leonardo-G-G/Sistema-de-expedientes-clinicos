<?php

namespace App\Http\Controllers;

use App\Models\NotaMedica;
use App\Models\HistoriaClinica;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotaMedicaController extends Controller
{
    // 📋 Mostrar lista de notas médicas del médico logueado
    public function index(Request $request)
    {
        $search = $request->input('search');
        $fecha  = $request->input('fecha');
        $medicoId = Auth::user()->Id_Usuario;

        $notas = NotaMedica::with('historiaClinica.expediente.paciente')
            ->whereHas('historiaClinica.expediente', function ($q) use ($medicoId) {
                $q->where('Medico_Id', $medicoId); // 🔒 Solo notas de expedientes del médico actual
            })
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

    // 🩺 Formulario para crear una nueva nota médica
    public function create($id = null)
    {
        $medicoId = Auth::user()->Id_Usuario;

        $historia = null;
        if ($id) {
            $historia = HistoriaClinica::with('expediente.paciente')
                ->whereHas('expediente', fn($q) => $q->where('Medico_Id', $medicoId))
                ->findOrFail($id);
        }

        $historias = HistoriaClinica::with('expediente.paciente')
            ->whereHas('expediente', fn($q) => $q->where('Medico_Id', $medicoId))
            ->get();

        return view('notas.create', compact('historia', 'historias'));
    }

    // 💾 Guardar nueva nota médica
    public function store(Request $request)
    {
        $request->validate([
            'Historia_Id' => 'required|exists:historia_clinica,Id_Historia',
            'Peso' => 'nullable|numeric',
            'Talla' => 'nullable|numeric',
            'Presion_Arterial' => 'nullable|string|max:20',
            'Frecuencia_Cardiaca' => 'nullable|integer',
            'Exploracion_Fisica' => 'nullable|string',
            'Diagnostico' => 'nullable|string',
            'Tratamiento' => 'nullable|string',
            'Plan_A_Seguir' => 'nullable|string',
        ]);

        $historia = HistoriaClinica::with('expediente')
            ->whereHas('expediente', fn($q) => $q->where('Medico_Id', Auth::user()->Id_Usuario))
            ->findOrFail($request->Historia_Id);

        NotaMedica::create([
            'Historia_Id' => $historia->Id_Historia,
            'Peso' => $request->Peso,
            'Talla' => $request->Talla,
            'Presion_Arterial' => $request->Presion_Arterial,
            'Frecuencia_Cardiaca' => $request->Frecuencia_Cardiaca,
            'Exploracion_Fisica' => $request->Exploracion_Fisica,
            'Diagnostico' => $request->Diagnostico,
            'Tratamiento' => $request->Tratamiento,
            'Plan_A_Seguir' => $request->Plan_A_Seguir,
            'Fecha' => now()->toDateString(),
            'Hora'  => now()->format('H:i:s'),
        ]);

        return redirect()->route('notas.index')->with('success', '✅ Nota médica registrada correctamente.');
    }

    // 📄 Ver una nota médica
    public function show($id)
    {
        $nota = NotaMedica::with('historiaClinica.expediente.paciente')
            ->whereHas('historiaClinica.expediente', fn($q) =>
                $q->where('Medico_Id', Auth::user()->Id_Usuario)
            )
            ->findOrFail($id);

        $historia = $nota->historiaClinica;

        return view('notas.show', compact('nota', 'historia'));
    }

    // ✏️ Editar nota médica existente
    public function edit($id)
    {
        $medicoId = Auth::user()->Id_Usuario;

        $nota = NotaMedica::whereHas('historiaClinica.expediente', fn($q) =>
            $q->where('Medico_Id', $medicoId)
        )->findOrFail($id);

        $historias = HistoriaClinica::with('expediente.paciente')
            ->whereHas('expediente', fn($q) => $q->where('Medico_Id', $medicoId))
            ->get();

        return view('notas.edit', compact('nota', 'historias'));
    }

    // 🔄 Actualizar nota médica
    public function update(Request $request, $id)
    {
        $medicoId = Auth::user()->Id_Usuario;

        $nota = NotaMedica::whereHas('historiaClinica.expediente', fn($q) =>
            $q->where('Medico_Id', $medicoId)
        )->findOrFail($id);

        $request->validate([
            'Historia_Id' => 'required|exists:historia_clinica,Id_Historia',
            'Peso' => 'nullable|numeric',
            'Talla' => 'nullable|numeric',
            'Presion_Arterial' => 'nullable|string|max:20',
            'Frecuencia_Cardiaca' => 'nullable|integer',
            'Exploracion_Fisica' => 'nullable|string',
            'Diagnostico' => 'nullable|string',
            'Tratamiento' => 'nullable|string',
            'Plan_A_Seguir' => 'nullable|string',
        ]);

        $nota->update([
            'Historia_Id' => $request->Historia_Id,
            'Peso' => $request->Peso,
            'Talla' => $request->Talla,
            'Presion_Arterial' => $request->Presion_Arterial,
            'Frecuencia_Cardiaca' => $request->Frecuencia_Cardiaca,
            'Exploracion_Fisica' => $request->Exploracion_Fisica,
            'Diagnostico' => $request->Diagnostico,
            'Tratamiento' => $request->Tratamiento,
            'Plan_A_Seguir' => $request->Plan_A_Seguir,
            'Fecha' => now()->toDateString(),
            'Hora'  => now()->format('H:i:s'),
        ]);

        return redirect()->route('notas.index')->with('success', '✅ Nota médica actualizada correctamente.');
    }

    // 🔍 Búsqueda AJAX de historias clínicas
    public function buscarHistorias(Request $request)
    {
        $q = $request->get('q', '');
        $medicoId = Auth::user()->Id_Usuario;

        $historias = HistoriaClinica::with('expediente.paciente')
            ->whereHas('expediente', fn($x) => $x->where('Medico_Id', $medicoId))
            ->whereHas('expediente.paciente', function ($query) use ($q) {
                $query->where('Nombre', 'like', "%{$q}%")
                      ->orWhere('Apellido', 'like', "%{$q}%");
            })
            ->limit(10)
            ->get()
            ->map(function ($h) {
                return [
                    'Id_Historia' => $h->Id_Historia,
                    'Nombre' => $h->expediente->paciente->Nombre,
                    'Apellido' => $h->expediente->paciente->Apellido
                ];
            });

        return response()->json($historias);
    }

    // 🗑️ Eliminar nota médica
    public function destroy($id)
    {
        $nota = NotaMedica::whereHas('historiaClinica.expediente', fn($q) =>
            $q->where('Medico_Id', Auth::user()->Id_Usuario)
        )->findOrFail($id);

        $nota->delete();

        return back()->with('success', '🗑️ Nota médica eliminada correctamente.');
    }
}
