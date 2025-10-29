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
        $search = trim($request->input('search'));

        $historias = HistoriaClinica::with('expediente.paciente')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('expediente.paciente', function ($q) use ($search) {
                    $q->where('Nombre', 'like', "%{$search}%")
                      ->orWhere('Apellido', 'like', "%{$search}%")
                      ->orWhereRaw("CONCAT(Nombre, ' ', Apellido) LIKE ?", ["%{$search}%"])
                      ->orWhereRaw("CONCAT(Apellido, ' ', Nombre) LIKE ?", ["%{$search}%"]);
                })
                ->orWhere('Padecimiento_Actual', 'like', "%{$search}%")
                ->orWhere('Exploracion_Fisica', 'like', "%{$search}%");
            })
            ->orderByDesc('Id_Historia')
            ->paginate(10)
            ->appends(['search' => $search]);

        return view('historia.index', compact('historias', 'search'));
    }

    public function create()
    {
        $expedientes = Expediente::with('paciente')->orderByDesc('Id_Expediente')->get();
        return view('historia.create', compact('expedientes'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'Expediente_Id' => 'required|exists:expediente,Id_Expediente',
            'Padecimiento_Actual' => 'required|string',
            'Exploracion_Fisica' => 'required|string',
        ]);

        if (HistoriaClinica::where('Expediente_Id', $request->Expediente_Id)->exists()) {
            return redirect()->back()
                ->withErrors(['Ya existe una historia clínica para este expediente.'])
                ->withInput();
        }

        DB::transaction(function () use ($validated, $request) {
            $historia = HistoriaClinica::create($validated);
            $normalize = fn($v) => in_array(strtolower($v), ['sí', 'si', '1', 'true'], true) ? 1 : 0;

            if ($request->filled('heredofamiliares')) {
                $data = $request->input('heredofamiliares');
                foreach (['Diabetes','Hipertension','Cancer'] as $c) if(isset($data[$c])) $data[$c]=$normalize($data[$c]);
                $historia->heredofamiliares()->create($data);
            }

            if ($request->filled('patologicos')) {
                $historia->patologicos()->create($request->input('patologicos'));
            }

            if ($request->filled('no_patologicos')) {
                $data = $request->input('no_patologicos');
                foreach(['Tabaquismo','Alcoholismo','Drogas'] as $c) if(isset($data[$c])) $data[$c]=$normalize($data[$c]);
                $historia->noPatologicos()->create($data);
            }

            if ($request->filled('ginecoobstetricos')) {
                $data = $request->input('ginecoobstetricos');
                if(isset($data['Ciclos_Dolor'])) $data['Ciclos_Dolor']=$normalize($data['Ciclos_Dolor']);
                $historia->ginecoobstetricos()->create($data);
            }

            if ($request->filled('nota_medica')) {
                $notas = $request->input('nota_medica');
                if(isset($notas['Peso']) || isset($notas['Talla'])) $notas=[$notas];
                foreach($notas as $nota) {
                    $nota['Fecha'] = now()->format('Y-m-d');
                    $nota['Hora'] = now()->format('H:i:s');
                    $historia->notaMedicas()->create($nota);
                }
            }
        });

        return redirect()->route('historia.index')
            ->with('success', '✅ Historia clínica registrada correctamente.');
    }

    public function edit($id)
    {
        $historia = HistoriaClinica::with([
            'expediente.paciente',
            'ginecoobstetricos',
            'heredofamiliares',
            'noPatologicos',
            'patologicos',
            'notaMedicas'
        ])->findOrFail($id);

        $expedientes = Expediente::with('paciente')->orderByDesc('Id_Expediente')->get();

        return view('historia.edit', compact('historia', 'expedientes'));
    }

    public function update(Request $request, $id)
    {
        $historia = HistoriaClinica::findOrFail($id);

        $validated = $request->validate([
            'Padecimiento_Actual' => 'required|string',
            'Exploracion_Fisica' => 'required|string',
        ]);

        DB::transaction(function () use ($historia, $request, $validated) {
            $historia->update($validated);
            $normalize = fn($v)=>in_array(strtolower($v),['sí','si','1','true'],true)?1:0;

            foreach([
                'heredofamiliares'=>['Diabetes','Hipertension','Cancer'],
                'no_patologicos'=>['Tabaquismo','Alcoholismo','Drogas'],
                'ginecoobstetricos'=>['Ciclos_Dolor']
            ] as $tipo=>$campos){
                if($request->filled($tipo)){
                    $data=$request->input($tipo);
                    foreach($campos as $c) if(isset($data[$c])) $data[$c]=$normalize($data[$c]);
                    $relation = $tipo==='no_patologicos'?'noPatologicos':($tipo==='ginecoobstetricos'?'ginecoobstetricos':$tipo);
                    $historia->$relation()->updateOrCreate(['Historia_Id'=>$historia->Id_Historia],$data);
                }
            }

            if($request->filled('nota_medica')){
                $notas=$request->input('nota_medica');
                if(isset($notas['Peso']) || isset($notas['Talla'])) $notas=[$notas];
                foreach($notas as $nota){
                    $nota['Fecha']=now()->format('Y-m-d');
                    $nota['Hora']=now()->format('H:i:s');
                    $historia->notaMedicas()->updateOrCreate(['Id_Nota'=>$nota['Id_Nota'] ?? null],$nota);
                }
            }
        });

        return redirect()->route('historia.index')
            ->with('success','✅ Historia clínica actualizada correctamente.');
    }

    public function destroy($id)
    {
        $historia=HistoriaClinica::findOrFail($id);
        DB::transaction(function() use($historia){
            $historia->ginecoobstetricos()->delete();
            $historia->heredofamiliares()->delete();
            $historia->noPatologicos()->delete();
            $historia->patologicos()->delete();
            $historia->notaMedicas()->delete();
            $historia->delete();
        });
        return redirect()->route('historia.index')->with('success','🗑️ Historia clínica eliminada correctamente.');
    }

    public function show($id)
    {
        $historia=HistoriaClinica::with([
            'expediente.paciente',
            'ginecoobstetricos',
            'heredofamiliares',
            'noPatologicos',
            'patologicos',
            'notaMedicas'
        ])->findOrFail($id);

        $relaciones = [
            'heredofamiliares'=>'Heredofamiliares',
            'noPatologicos'=>'No Patológicos',
            'patologicos'=>'Patológicos',
            'ginecoobstetricos'=>'Ginecoobstétricos',
        ];

        return view('historia.show',compact('historia','relaciones'));
    }
}
