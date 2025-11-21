<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Paciente;
use App\Models\Expediente;
use App\Models\NotaMedica;
use App\Models\HistoriaClinica;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $usuario = Auth::user();
        $hoy = now()->toDateString();

        // Totales
        $totalExpedientes = Expediente::where('Medico_Id', $usuario->Id_Usuario)->count();

        $totalPacientes = Paciente::whereHas('expediente', function ($q) use ($usuario) {
            $q->where('Medico_Id', $usuario->Id_Usuario);
        })->count();

        // Pacientes registrados hoy (basado en expedientes)
        $pacientesHoy = Expediente::where('Medico_Id', $usuario->Id_Usuario)
            ->whereDate('Fecha_Apertura', $hoy)
            ->count();

        // Notas médicas hoy
        $notasHoy = NotaMedica::whereDate('Fecha', $hoy)
            ->whereHas('historiaClinica.expediente', function ($q) use ($usuario) {
                $q->where('Medico_Id', $usuario->Id_Usuario);
            })
            ->count();

        // Actividades recientes → SOLO notas médicas
        $actividades = [];

        $ultimasNotas = NotaMedica::with('historiaClinica.expediente.paciente')
            ->whereHas('historiaClinica.expediente', function ($q) use ($usuario) {
                $q->where('Medico_Id', $usuario->Id_Usuario);
            })
            ->orderBy('Fecha', 'DESC')
            ->orderBy('Hora', 'DESC')
            ->limit(10)
            ->get();

        foreach ($ultimasNotas as $nota) {
            $pac = $nota->historiaClinica->expediente->paciente;

            $horaFormateada = Carbon::parse($nota->Fecha . ' ' . $nota->Hora)
                ->format('d/m/Y h:i A');

            $actividades[] = [
                'descripcion' => 'Nota médica creada para ' . $pac->Nombre . ' ' . $pac->Apellido,
                'hora'        => $horaFormateada,
                'icono'       => 'bi-journal-medical',
            ];
        }

        return view('dashboard', compact(
            'totalPacientes',
            'totalExpedientes',
            'pacientesHoy',
            'notasHoy',
            'actividades',
            'usuario'
        ));
    }
}
