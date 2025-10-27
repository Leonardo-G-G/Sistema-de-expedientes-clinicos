<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\HistoriaClinica;
use App\Models\Expediente;

class HistoriaClinicaController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $historias = HistoriaClinica::with('expediente.paciente')
            ->when($search, function ($query, $search) {
                $query->whereHas('expediente.paciente', function ($q) use ($search) {
                    $q->where('Nombre', 'like', "%{$search}%")
                      ->orWhere('Apellido', 'like', "%{$search}%")
                      ->orWhereRaw("CONCAT(Nombre, ' ', Apellido) LIKE ?", ["%{$search}%"]);
                })
                ->orWhere('Padecimiento_Actual', 'like', "%{$search}%")
                ->orWhere('Exploracion_Fisica', 'like', "%{$search}%");
            })
            ->orderBy('Id_Historia', 'desc')
            ->paginate(10);

        return view('historia.index', compact('historias'));
    }

    public function create()
    {
        $expedientes = Expediente::with('paciente')->get();
        return view('historia.create', compact('expedientes'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'Expediente_Id' => 'required|exists:expediente,Id_Expediente',
            'Padecimiento_Actual' => 'required|string',
            'Exploracion_Fisica' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $validatedData) {
            $historia = HistoriaClinica::create($validatedData);

            // Función para convertir "Sí"/"No" a 1/0
            $normalizeBoolean = function ($value) {
                return in_array(strtolower($value), ['sí', 'si', '1', 'true'], true) ? 1 : 0;
            };

            // 🔸 Heredofamiliares
            if ($request->filled('heredofamiliares')) {
                $data = $request->input('heredofamiliares');
                foreach (['Diabetes', 'Hipertension', 'Cancer'] as $campo) {
                    if (isset($data[$campo])) {
                        $data[$campo] = $normalizeBoolean($data[$campo]);
                    }
                }
                $data['Historia_Id'] = $historia->Id_Historia;
                $historia->heredofamiliares()->create($data);
            }

            // 🔸 Patológicos
            if ($request->filled('patologicos')) {
                $data = $request->input('patologicos');
                $data['Historia_Id'] = $historia->Id_Historia;
                $historia->patologicos()->create($data);
            }

            // 🔸 No Patológicos
            if ($request->filled('no_patologicos')) {
                $data = $request->input('no_patologicos');
                foreach (['Tabaquismo', 'Alcoholismo', 'Drogas'] as $campo) {
                    if (isset($data[$campo])) {
                        $data[$campo] = $normalizeBoolean($data[$campo]);
                    }
                }
                $data['Historia_Id'] = $historia->Id_Historia;
                $historia->noPatologicos()->create($data);
            }

            // 🔸 Ginecoobstétricos
            if ($request->filled('ginecoobstetricos')) {
                $data = $request->input('ginecoobstetricos');
                foreach (['Ciclos_Regulares', 'Ciclos_Dolor'] as $campo) {
                    if (isset($data[$campo])) {
                        $data[$campo] = $normalizeBoolean($data[$campo]);
                    }
                }
                $data['Historia_Id'] = $historia->Id_Historia;
                $historia->ginecoobstetricos()->create($data);
            }

            // 🔸 Nota Médica (incluye Observación)
            if ($request->filled('nota_medica')) {
                $nota = $request->input('nota_medica');
                $nota['Expediente_Id'] = $historia->Expediente_Id;

                // ✅ Fecha y hora actuales
                $nota['Fecha'] = now()->format('Y-m-d');
                $nota['Hora'] = now()->format('H:i:s');

                // Si el campo Observacion no está, lo inicializamos
                $nota['Observacion'] = $nota['Observacion'] ?? null;

                $historia->expediente->notaMedicas()->create($nota);
            }
        });

        return redirect()->route('historia.index')
                         ->with('success', 'Historia clínica registrada correctamente.');
    }

    public function edit($id)
    {
        $historia = HistoriaClinica::with(
            'expediente.paciente',
            'ginecoobstetricos',
            'heredofamiliares',
            'noPatologicos',
            'patologicos'
        )->findOrFail($id);

        $expedientes = Expediente::with('paciente')->get();

        return view('historia.edit', compact('historia', 'expedientes'));
    }

    public function update(Request $request, $id)
    {
        $historia = HistoriaClinica::findOrFail($id);

        $validatedData = $request->validate([
            'Padecimiento_Actual' => 'required|string',
            'Exploracion_Fisica' => 'required|string',
        ]);

        DB::transaction(function () use ($request, $historia, $validatedData) {
            $historia->update($validatedData);

            $normalizeBoolean = function ($value) {
                return in_array(strtolower($value), ['sí', 'si', '1', 'true'], true) ? 1 : 0;
            };

            foreach (['heredofamiliares', 'patologicos', 'no_patologicos', 'ginecoobstetricos'] as $tipo) {
                if ($request->filled($tipo)) {
                    $data = $request->input($tipo);

                    if ($tipo === 'heredofamiliares') {
                        foreach (['Diabetes', 'Hipertension', 'Cancer'] as $campo) {
                            if (isset($data[$campo])) {
                                $data[$campo] = $normalizeBoolean($data[$campo]);
                            }
                        }
                    }

                    if ($tipo === 'no_patologicos') {
                        foreach (['Tabaquismo', 'Alcoholismo', 'Drogas'] as $campo) {
                            if (isset($data[$campo])) {
                                $data[$campo] = $normalizeBoolean($data[$campo]);
                            }
                        }
                    }

                    if ($tipo === 'ginecoobstetricos') {
                        foreach (['Ciclos_Regulares', 'Ciclos_Dolor'] as $campo) {
                            if (isset($data[$campo])) {
                                $data[$campo] = $normalizeBoolean($data[$campo]);
                            }
                        }
                    }

                    $data['Historia_Id'] = $historia->Id_Historia;
                    $relation = $tipo === 'no_patologicos' ? 'noPatologicos' : $tipo;
                    $historia->$relation()->updateOrCreate(['Historia_Id' => $historia->Id_Historia], $data);
                }
            }

            // 🔸 Actualizar Nota Médica (incluye Observación)
            if ($request->filled('nota_medica')) {
                $nota = $request->input('nota_medica');
                $nota['Expediente_Id'] = $historia->Expediente_Id;

                // ✅ Fecha y hora actuales
                $nota['Fecha'] = now()->format('Y-m-d');
                $nota['Hora'] = now()->format('H:i:s');

                // Si falta Observacion, se inicializa como null
                $nota['Observacion'] = $nota['Observacion'] ?? null;

                $historia->expediente->notaMedicas()->updateOrCreate(
                    ['Expediente_Id' => $historia->Expediente_Id],
                    $nota
                );
            }
        });

        return redirect()->route('historia.index')
                         ->with('success', 'Historia clínica actualizada correctamente.');
    }

    public function destroy($id)
    {
        $historia = HistoriaClinica::findOrFail($id);

        $historia->ginecoobstetricos()->delete();
        $historia->heredofamiliares()->delete();
        $historia->noPatologicos()->delete();
        $historia->patologicos()->delete();
        $historia->expediente->notaMedicas()->where('Expediente_Id', $historia->Expediente_Id)->delete();

        $historia->delete();

        return redirect()->route('historia.index')
                         ->with('success', 'Historia clínica y antecedentes eliminados correctamente.');
    }

    public function show($id)
    {
        $historia = HistoriaClinica::with(
            'expediente.paciente',
            'ginecoobstetricos',
            'heredofamiliares',
            'noPatologicos',
            'patologicos'
        )->findOrFail($id);

        $relaciones = [
            'heredofamiliares' => 'Heredofamiliares',
            'noPatologicos' => 'No Patológicos',
            'patologicos' => 'Patológicos',
            'ginecoobstetricos' => 'Ginecoobstétricos',
        ];

        return view('historia.show', compact('historia', 'relaciones'));
    }
}
