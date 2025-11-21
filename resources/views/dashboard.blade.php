@extends('layouts.app')

@section('titulo', 'Panel del Sistema Clínico')
@section('icono')
    <i class="bi bi-speedometer2 text-primary"></i>
@endsection
@section('dashboard_active', 'active')

@section('contenido')
{{-- Mensaje de bienvenida dinámico --}}
@php
    $hora = now()->format('H');
    if ($hora < 12) {
        $saludo = 'Buenos días';
    } elseif ($hora < 19) {
        $saludo = 'Buenas tardes';
    } else {
        $saludo = 'Buenas noches';
    }
@endphp

<div class="mb-4">
    <div class="card shadow-sm border-0">
        <div class="card-body d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3">
            <div>
                <h5 class="mb-1 fw-semibold">
                    {{ $saludo }}, <strong>{{ Auth::user()->Nombre ?? Auth::user()->name }}</strong>
                </h5>
                <p class="mb-0 text-muted">
                    Bienvenido al sistema clínico. Accede rápidamente a los módulos principales o revisa las estadísticas del día.
                </p>
            </div>
            <div class="text-md-end">
                <small class="text-muted">
                    Último acceso: {{ optional(Auth::user()->ultimo_acceso)->format('d/m/Y H:i') ?? now()->format('d/m/Y H:i') }}
                </small>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row g-4">

        <!-- PACIENTES -->
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-person-bounding-box card-icon text-primary" style="font-size: 3rem;"></i>
                    <h5 class="card-title fw-semibold mt-2 text-primary">Pacientes Registrados</h5>
                    <p class="display-6 fw-bold text-dark">{{ $totalPacientes ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- EXPEDIENTES -->
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-clipboard-data card-icon text-success" style="font-size: 3rem;"></i>
                    <h5 class="card-title fw-semibold mt-2 text-success">Expedientes Clínicos</h5>
                    <p class="display-6 fw-bold text-dark">{{ $totalExpedientes ?? 0 }}</p>
                </div>
            </div>
        </div>

        <!-- NOTAS HOY -->
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0">
                <div class="card-body text-center">
                    <i class="bi bi-journal-medical card-icon text-warning" style="font-size: 3rem;"></i>
                    <h5 class="card-title fw-semibold mt-2 text-warning">Notas Médicas Hoy</h5>
                    <p class="display-6 fw-bold text-dark">{{ $notasHoy ?? 0 }}</p>
                </div>
            </div>
        </div>

    </div>

    {{-- 📌 NOTAS MÉDICAS RECIENTES --}}
    <div class="row mt-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white">
                    <h5 class="fw-semibold mb-0">
                        <i class="bi bi-clock-history text-primary"></i> Notas médicas recientes
                    </h5>
                </div>

                <div class="card-body">
                    @if (count($actividades) == 0)
                        <p class="text-muted mb-0">No hay notas médicas registradas recientemente.</p>
                    @else
                        <ul class="list-group list-group-flush">

                            @foreach ($actividades as $actividad)
                                <li class="list-group-item d-flex gap-3 align-items-start">
                                    <div class="text-primary">
                                        <i class="bi {{ $actividad['icono'] }} fs-4"></i>
                                    </div>
                                    <div>
                                        <strong>{{ $actividad['descripcion'] }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            @php
                                                try {
                                                    $fechaFormateada = \Carbon\Carbon::parse($actividad['hora'])
                                                        ->format('d/m/Y h:i A');
                                                } catch (\Exception $e) {
                                                    $fechaFormateada = $actividad['hora'];
                                                }
                                            @endphp
                                            {{ $fechaFormateada }}
                                        </small>
                                    </div>
                                </li>
                            @endforeach

                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
