<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Paciente;
use App\Models\Expediente;


class DashboardController extends Controller
{
    public function index()
{
    $usuario = Auth::user();

    $totalExpedientes = Expediente::where('Medico_Id', $usuario->Id_Usuario)->count();

    $totalPacientes = Paciente::whereHas('expediente', function ($q) use ($usuario) {
        $q->where('Medico_Id', $usuario->Id_Usuario);
    })->count();

    return view('dashboard', compact('totalPacientes', 'totalExpedientes', 'usuario'));
}
}
