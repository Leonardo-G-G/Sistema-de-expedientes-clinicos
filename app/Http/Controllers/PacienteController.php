<?php

namespace App\Http\Controllers;

use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PacienteController extends Controller
{
    /**
     * 📋 Listado de pacientes con buscador avanzado
     */
   public function index(Request $request)
{
    $search = trim($request->input('search'));
    $medicoId = Auth::user()->Id_Usuario;

    $pacientes = Paciente::where(function ($query) use ($medicoId) {
            $query->whereDoesntHave('expediente') // Pacientes sin expediente
                  ->orWhereHas('expediente', function ($q) use ($medicoId) {
                      $q->where('Medico_Id', $medicoId);
                  });
        })
        ->when($search, function ($query, $search) {
            $query->where(function ($subquery) use ($search) {
                $subquery->where('Nombre', 'like', "%{$search}%")
                         ->orWhere('Apellido', 'like', "%{$search}%")
                         ->orWhereRaw("CONCAT(Nombre, ' ', Apellido) LIKE ?", ["%{$search}%"]);
            });
        })
        ->orderByDesc('Id_Paciente')
        ->paginate(10);

    return view('pacientes.index', compact('pacientes', 'search'));
}

    /**
     * ➕ Mostrar formulario de creación
     */
    public function create()
    {
        return view('pacientes.create');
    }

    /**
     * 💾 Guardar nuevo paciente
     */
    public function store(Request $request)
    {
        $request->validate([
            'Nombre' => 'required|string|max:100',
            'Apellido' => 'required|string|max:100',
            'Sexo' => 'nullable|string|max:10',
            'Telefono' => 'nullable|string|max:15',
            'Lugar_Origen' => 'nullable|string|max:150',
            'Contacto_Emergencia' => 'nullable|string|max:150',
            'Fecha_Nacimiento' => 'nullable|date|before_or_equal:today'
        ]);

        Paciente::create($request->only([
            'Nombre',
            'Apellido',
            'Sexo',
            'Telefono',
            'Lugar_Origen',
            'Contacto_Emergencia',
            'Fecha_Nacimiento'
        ]));

        return redirect()->route('pacientes.index')->with('success', 'Paciente registrado exitosamente.');

    }

    /**
     * ✏️ Editar paciente existente
     */
    public function edit($Id_Paciente)
    {
        $paciente = Paciente::findOrFail($Id_Paciente);
        return view('pacientes.edit', compact('paciente'));
    }

    /**
     * 🔄 Actualizar datos de paciente
     */
    public function update(Request $request, $Id_Paciente)
    {
        $paciente = Paciente::findOrFail($Id_Paciente);

        $request->validate([
            'Nombre' => 'required|string|max:100',
            'Apellido' => 'required|string|max:100',
            'Sexo' => 'nullable|string|max:10',
            'Telefono' => 'nullable|string|max:15',
            'Lugar_Origen' => 'nullable|string|max:150',
            'Contacto_Emergencia' => 'nullable|string|max:150',
            'Fecha_Nacimiento' => 'nullable|date|before_or_equal:today'
        ]);

        $paciente->update($request->only([
            'Nombre',
            'Apellido',
            'Sexo',
            'Telefono',
            'Lugar_Origen',
            'Contacto_Emergencia',
            'Fecha_Nacimiento'
        ]));

        return redirect()->route('pacientes.index')
                 ->with('success', ' Datos del paciente actualizados correctamente.');

    }

    /**
     * ❌ Eliminar paciente
     */
    public function destroy($Id_Paciente)
    {
        $paciente = Paciente::findOrFail($Id_Paciente);
        $paciente->delete();

        return redirect()->route('pacientes.index')
                         ->with('success', 'Paciente eliminado correctamente.');
    }

    /**
     * 👁️ Mostrar información detallada de un paciente
     */
    public function show($Id_Paciente)
    {
        $paciente = Paciente::with('expediente')->findOrFail($Id_Paciente);
        return view('pacientes.show', compact('paciente'));
    }

    /**
     * 🔍 Buscar pacientes por nombre, apellido o expediente (para selects dinámicos o AJAX)
     */
    public function buscar(Request $request)
    {
        $query = trim($request->get('q', ''));

        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $pacientes = DB::table('paciente')
            ->join('expediente', 'paciente.Id_Paciente', '=', 'expediente.Paciente_Id')
            ->select(
                'paciente.Id_Paciente',
                'paciente.Nombre',
                'paciente.Apellido',
                'expediente.Id_Expediente'
            )
            ->where(function ($q) use ($query) {
                $q->where('paciente.Nombre', 'like', "%{$query}%")
                  ->orWhere('paciente.Apellido', 'like', "%{$query}%")
                  ->orWhereRaw("CONCAT(paciente.Nombre, ' ', paciente.Apellido) LIKE ?", ["%{$query}%"])
                  ->orWhereRaw("CONCAT(paciente.Apellido, ' ', paciente.Nombre) LIKE ?", ["%{$query}%"])
                  ->orWhere('expediente.Id_Expediente', 'like', "%{$query}%");
            })
            ->distinct()
            ->limit(10)
            ->get();

        return response()->json($pacientes);
    }
}
