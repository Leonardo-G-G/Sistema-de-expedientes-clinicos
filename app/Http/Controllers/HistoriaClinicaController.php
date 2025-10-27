<?php

namespace App\Http\Controllers;

use App\Models\HistoriaClinica;
use App\Models\Expediente;
use App\Models\AntecedenteNoPatologico;
use App\Models\AntecedenteHeredofamiliar;
use App\Models\AntecedentePatologico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoriaClinicaController extends Controller
{
    // 📋 Mostrar lista de historias clínicas
    public function index()
    {
        $historias = HistoriaClinica::with('expediente.paciente')
            ->orderBy('Id_Historia', 'DESC')
            ->paginate(10);

        return view('admin.historia.index', compact('historias'));
    }

    // ➕ Formulario para crear nueva historia
    public function create()
    {
        // Solo mostrar expedientes que NO tengan historia clínica
        $expedientes = Expediente::doesntHave('historiaClinica')
            ->with('paciente')
            ->get();

        return view('admin.historia.create', compact('expedientes'));
    }

    // 💾 Guardar historia clínica
    public function store(Request $request)
    {
        $request->validate([
            'Expediente_Id' => 'required|exists:expedientes,Id_Expediente',
            'Padecimiento_Actual' => 'required|string',
        ]);

        DB::beginTransaction();

        try {
            // Validar que el expediente no tenga ya una historia
            if (HistoriaClinica::where('Expediente_Id', $request->Expediente_Id)->exists()) {
                return back()->with('error', '⚠️ Este expediente ya tiene una historia clínica registrada.');
            }

            // 1️⃣ Crear historia clínica principal
            $historia = HistoriaClinica::create([
                'Expediente_Id' => $request->Expediente_Id,
                'Padecimiento_Actual' => $request->Padecimiento_Actual,
                'Exploracion_Fisica' => $request->Exploracion_Fisica,
                'Diagnostico' => $request->Diagnostico
            ]);

            // 2️⃣ Antecedentes heredofamiliares
            $heredo = $request->input('heredofamiliares', []);
            AntecedenteHeredofamiliar::create([
                'Historia_Id' => $historia->Id_Historia,
                'Diabetes' => $heredo['Diabetes'] ?? 'No',
                'Hipertension' => $heredo['Hipertension'] ?? 'No',
                'Cancer' => $heredo['Cancer'] ?? 'No',
                'Trastornos_Mentales' => $heredo['Trastornos_Mentales'] ?? 'No',
                'Enfermedades_Cronicas' => $heredo['Enfermedades_Cronicas'] ?? 'No',
                'Otros' => $heredo['Otros'] ?? null,
            ]);

            // 3️⃣ Antecedentes patológicos
            $patologicos = $request->input('patologicos', []);
            AntecedentePatologico::create([
                'Historia_Id' => $historia->Id_Historia,
                'Cirugias' => $patologicos['Cirugias'] ?? null,
                'Alergias' => $patologicos['Alergias'] ?? null,
                'Hospitalizaciones' => $patologicos['Hospitalizaciones'] ?? null,
                'Enfermedades_Infecciosas' => $patologicos['Enfermedades_Infecciosas'] ?? null,
                'Transfusiones' => $patologicos['Transfusiones'] ?? null,
            ]);

            // 4️⃣ Antecedentes no patológicos
            $no_patologicos = $request->input('no_patologicos', []);
            AntecedenteNoPatologico::create([
                'Historia_Id' => $historia->Id_Historia,
                'Tipo_Vivienda' => $no_patologicos['Tipo_Vivienda'] ?? null,
                'Religion' => $no_patologicos['Religion'] ?? null,
                'Alimentacion' => $no_patologicos['Alimentacion'] ?? null,
                'Actividad_Fisica' => $no_patologicos['Actividad_Fisica'] ?? null,
                'Tabaquismo' => $no_patologicos['Tabaquismo'] ?? 'No',
                'Alcoholismo' => $no_patologicos['Alcoholismo'] ?? 'No',
                'Drogas' => $no_patologicos['Drogas'] ?? 'No',
            ]);

            DB::commit();
            return redirect()->route('historia.index')->with('success', '✅ Historia clínica registrada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', '❌ Error al registrar: ' . $e->getMessage());
        }
    }

    // 👁️ Ver historia clínica individual
    public function show($id)
    {
        $historia = HistoriaClinica::with(['expediente.paciente', 'heredofamiliares', 'patologicos', 'noPatologicos'])
            ->findOrFail($id);

        return view('admin.historia.show', compact('historia'));
    }

    // ✏️ Editar historia clínica
    public function edit($id)
    {
        $historia = HistoriaClinica::with(['heredofamiliares', 'patologicos', 'noPatologicos'])->findOrFail($id);
        return view('admin.historia.edit', compact('historia'));
    }

    // 🔄 Actualizar historia clínica
    public function update(Request $request, $id)
    {
        $historia = HistoriaClinica::findOrFail($id);

        DB::beginTransaction();
        try {
            $historia->update([
                'Padecimiento_Actual' => $request->Padecimiento_Actual,
                'Exploracion_Fisica' => $request->Exploracion_Fisica,
                'Diagnostico' => $request->Diagnostico
            ]);

            // Actualizar antecedentes
            $historia->heredofamiliares->update($request->input('heredofamiliares', []));
            $historia->patologicos->update($request->input('patologicos', []));
            $historia->noPatologicos->update($request->input('no_patologicos', []));

            DB::commit();
            return redirect()->route('historia.index')->with('success', '✅ Historia clínica actualizada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', '❌ Error al actualizar: ' . $e->getMessage());
        }
    }

    // 🗑️ Eliminar historia clínica
    public function destroy($id)
    {
        $historia = HistoriaClinica::findOrFail($id);

        DB::beginTransaction();
        try {
            $historia->heredofamiliares()->delete();
            $historia->patologicos()->delete();
            $historia->noPatologicos()->delete();
            $historia->delete();

            DB::commit();
            return redirect()->route('historia.index')->with('success', '🗑️ Historia clínica eliminada correctamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', '❌ Error al eliminar: ' . $e->getMessage());
        }
    }
}
