<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\HistoriaClinica;
use App\Models\Expediente;

class HistoriaClinicaController extends Controller
{
    /** 
     * 📋 Listado de historias clínicas (solo del médico autenticado)
     */
    public function index(Request $request)
    {
        $search = trim($request->input('search'));
        $medicoId = Auth::user()->Id_Usuario;

        $historias = HistoriaClinica::with('expediente.paciente')
            ->whereHas('expediente', fn($q) => $q->where('Medico_Id', $medicoId))
            ->when($search, function ($query) use ($search) {
                $query->whereHas('expediente.paciente', function ($q) use ($search) {
                    $q->where('Nombre', 'like', "%{$search}%")
                      ->orWhere('Apellido', 'like', "%{$search}%")
                      ->orWhereRaw("CONCAT(Nombre, ' ', Apellido) LIKE ?", ["%{$search}%"])
                      ->orWhereRaw("CONCAT(Apellido, ' ', Nombre) LIKE ?", ["%{$search}%"]);
                })
                ->orWhereHas('notaMedicas', function ($q) use ($search) {
                    $q->where('Exploracion_Fisica', 'like', "%{$search}%");
                });
            })
            ->orderByDesc('Id_Historia')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('historia.index', compact('historias', 'search'));
    }

    /**
     * 🩺 Formulario de creación
     */
    public function create()
    {
        $expedientes = Expediente::with('paciente')
            ->where('Medico_Id', Auth::user()->Id_Usuario)
            ->orderByDesc('Id_Expediente')
            ->get();

        return view('historia.create', compact('expedientes'));
    }

    /**
     * 🔍 Buscar pacientes (AJAX)
     */
    public function buscarPacientes(Request $request)
    {
        $term = $request->input('term', '');
        $medicoId = Auth::user()->Id_Usuario;

        $resultados = Expediente::with('paciente')
            ->where('Medico_Id', $medicoId)
            ->whereHas('paciente', function ($q) use ($term) {
                $q->where('Nombre', 'like', "%{$term}%")
                  ->orWhere('Apellido', 'like', "%{$term}%");
            })
            ->limit(10)
            ->get()
            ->map(function ($expediente) {
                return [
                    'id' => $expediente->Id_Expediente,
                    'nombre' => $expediente->paciente->Nombre . ' ' . $expediente->paciente->Apellido,
                ];
            });

        return response()->json($resultados);
    }

    /**
     * 💾 Guardar nueva historia clínica
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'Expediente_Id' => 'required|exists:expediente,Id_Expediente',
            'nota_medica.Exploracion_Fisica' => 'required|string',
        ]);

        $expediente = Expediente::where('Id_Expediente', $request->Expediente_Id)
            ->where('Medico_Id', Auth::user()->Id_Usuario)
            ->first();

        if (!$expediente) {
            return back()->withErrors(['No tienes permiso para crear una historia clínica para este expediente.']);
        }

        if (HistoriaClinica::where('Expediente_Id', $request->Expediente_Id)->exists()) {
            return back()->withErrors(['Ya existe una historia clínica para este expediente.'])->withInput();
        }

        DB::transaction(function () use ($request) {
            $historia = HistoriaClinica::create([
                'Expediente_Id' => $request->Expediente_Id,
            ]);

            $normalize = fn($v) => in_array(strtolower($v), ['sí', 'si', '1', 'true'], true) ? 1 : 0;

            // 🔹 Heredofamiliares
            if ($request->filled('heredofamiliares')) {
                $data = $request->input('heredofamiliares');
                foreach (['Diabetes', 'Hipertension', 'Cancer'] as $campo) {
                    if (isset($data[$campo])) $data[$campo] = $normalize($data[$campo]);
                }
                $historia->heredofamiliares()->create($data);
            }

            // 🔹 Patológicos
            if ($request->filled('patologicos')) {
                $historia->patologicos()->create($request->input('patologicos'));
            }

            // 🔹 No patológicos
            if ($request->filled('no_patologicos')) {
                $data = $request->input('no_patologicos');
                foreach (['Tabaquismo', 'Alcoholismo', 'Drogas'] as $campo) {
                    if (isset($data[$campo])) $data[$campo] = $normalize($data[$campo]);
                }
                $data['Tipo_Sangre'] = $data['Tipo_Sangre'] ?? null;
                $historia->noPatologicos()->create($data);
            }

            // 🔹 Ginecoobstétricos
            if ($request->filled('ginecoobstetricos')) {
                $data = $request->input('ginecoobstetricos');
                if (isset($data['Ciclos_Dolor'])) $data['Ciclos_Dolor'] = $normalize($data['Ciclos_Dolor']);
                $historia->ginecoobstetricos()->create($data);
            }

            // 🔹 Nota médica
            if ($request->filled('nota_medica')) {
                $nota = $request->input('nota_medica');
                $nota['Fecha'] = now()->format('Y-m-d');
                $nota['Hora'] = now()->format('H:i:s');
                $historia->notaMedicas()->create($nota);
            }
        });

        return redirect()->route('historia.index')->with('success', '✅ Historia clínica registrada correctamente.');
    }

    /**
     * ✏️ Editar historia clínica
     */
    public function edit($id)
    {
        $medicoId = Auth::user()->Id_Usuario;

        $historia = HistoriaClinica::with([
            'expediente.paciente',
            'ginecoobstetricos',
            'heredofamiliares',
            'noPatologicos',
            'patologicos',
            'notaMedicas'
        ])
        ->whereHas('expediente', fn($q) => $q->where('Medico_Id', $medicoId))
        ->findOrFail($id);

        $expedientes = Expediente::with('paciente')
            ->where('Medico_Id', $medicoId)
            ->orderByDesc('Id_Expediente')
            ->get();

        return view('historia.edit', compact('historia', 'expedientes'));
    }

    /**
     * 🔄 Actualizar historia clínica
     */
    public function update(Request $request, $id)
    {
        $medicoId = Auth::user()->Id_Usuario;

        $historia = HistoriaClinica::whereHas('expediente', fn($q) =>
            $q->where('Medico_Id', $medicoId)
        )->findOrFail($id);

        $request->validate([
            'nota_medica.Exploracion_Fisica' => 'required|string',
        ]);

        DB::transaction(function () use ($historia, $request) {
            $normalize = fn($v) => in_array(strtolower($v), ['sí', 'si', '1', 'true'], true) ? 1 : 0;

            // 🔹 Actualizar Heredofamiliares, No Patológicos, Ginecoobstétricos
            foreach ([
                'heredofamiliares' => ['Diabetes', 'Hipertension', 'Cancer'],
                'no_patologicos' => ['Tabaquismo', 'Alcoholismo', 'Drogas'],
                'ginecoobstetricos' => ['Ciclos_Dolor']
            ] as $tipo => $campos) {
                if ($request->filled($tipo)) {
                    $data = $request->input($tipo);
                    foreach ($campos as $campo) {
                        if (isset($data[$campo])) $data[$campo] = $normalize($data[$campo]);
                    }

                    if ($tipo === 'no_patologicos' && !isset($data['Tipo_Sangre'])) {
                        $data['Tipo_Sangre'] = null;
                    }

                    $relacion = $tipo === 'no_patologicos'
                        ? 'noPatologicos'
                        : ($tipo === 'ginecoobstetricos' ? 'ginecoobstetricos' : $tipo);

                    $historia->$relacion()->updateOrCreate(
                        ['Historia_Id' => $historia->Id_Historia],
                        $data
                    );
                }
            }

            // 🔹 Patológicos
            if ($request->filled('patologicos')) {
                $historia->patologicos()->updateOrCreate(
                    ['Historia_Id' => $historia->Id_Historia],
                    $request->input('patologicos')
                );
            }

            // 🔹 Nota médica
            if ($request->filled('nota_medica')) {
                $nota = $request->input('nota_medica');
                $nota['Fecha'] = now()->format('Y-m-d');
                $nota['Hora'] = now()->format('H:i:s');
                $historia->notaMedicas()->updateOrCreate(
                    ['Historia_Id' => $historia->Id_Historia],
                    $nota
                );
            }
        });

        return redirect()->route('historia.index')->with('success', '✅ Historia clínica actualizada correctamente.');
    }

    /**
     * 🗑️ Eliminar historia clínica
     */
    public function destroy($id)
    {
        $historia = HistoriaClinica::whereHas('expediente', fn($q) =>
            $q->where('Medico_Id', Auth::user()->Id_Usuario)
        )->findOrFail($id);

        DB::transaction(function () use ($historia) {
            $historia->ginecoobstetricos()->delete();
            $historia->heredofamiliares()->delete();
            $historia->noPatologicos()->delete();
            $historia->patologicos()->delete();
            $historia->notaMedicas()->delete();
            $historia->delete();
        });

        return redirect()->route('historia.index')->with('success', '🗑️ Historia clínica eliminada correctamente.');
    }

    /**
     * 👁️ Mostrar historia clínica
     */
    public function show($id)
    {
        $historia = HistoriaClinica::with([
            'expediente.paciente',
            'ginecoobstetricos',
            'heredofamiliares',
            'noPatologicos',
            'patologicos',
            'notaMedicas'
        ])
        ->whereHas('expediente', fn($q) =>
            $q->where('Medico_Id', Auth::user()->Id_Usuario)
        )
        ->findOrFail($id);

        $relaciones = [
            'heredofamiliares' => 'Heredofamiliares',
            'noPatologicos' => 'No Patológicos',
            'patologicos' => 'Patológicos',
            'ginecoobstetricos' => 'Ginecoobstétricos',
        ];

        return view('historia.show', compact('historia', 'relaciones'));
    }
}
