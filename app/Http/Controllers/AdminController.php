<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Expediente;
use App\Models\Usuario;

class AdminController extends Controller
{
    public function index()
    {
        // 📊 Contadores generales
        $totalPacientes = Paciente::count();
        $totalExpedientes = Expediente::count();
        $totalMedicos = Usuario::where('Rol_Id', 2)->count(); // Rol 2 = Médico

        // 🔁 Pasamos las variables a la vista
        return view('admin.dashboard', compact('totalPacientes', 'totalExpedientes', 'totalMedicos'));
    }
}
