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

            <!-- Puedes agregar más tarjetas aquí -->

        </div>
    </div>
@endsection
