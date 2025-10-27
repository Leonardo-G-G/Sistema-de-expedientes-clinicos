<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Paciente;
use App\Models\HistoriaClinica;

class DashboardController extends Controller
{
    public function index()
    {
        // Contadores (ejemplo)
        $totalPacientes = Paciente::count();
        $totalExpedientes = HistoriaClinica::count();

        // Usuario autenticado
        $usuario = Auth::user();

        return view('dashboard', compact('totalPacientes', 'totalExpedientes', 'usuario'));
    }
}
