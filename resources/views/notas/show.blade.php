@extends('layouts.app')

@section('icono')
    <i class="bi bi-clipboard2-pulse text-primary"></i>
@endsection

@section('titulo', 'Nota Médica')

@section('contenido')
    <div class="container mt-4">
        <div class="card mb-4 shadow-sm border-0 rounded-4">
            <div class="card-header bg-light fw-bold text-primary">
                <i class="bi bi-journal-text"></i> Información General
            </div>
            <div class="card-body">
                <p><strong>Fecha:</strong> {{ $nota->Fecha ?? '---' }} | <strong>Hora:</strong> {{ $nota->Hora ?? '---' }}</p>
                <hr>
                <div class="row">
                    <div class="col-md-3"><p><strong>Peso:</strong> {{ $nota->Peso ?? '---' }} kg</p></div>
                    <div class="col-md-3"><p><strong>Talla:</strong> {{ $nota->Talla ?? '---' }} m</p></div>
                    <div class="col-md-3"><p><strong>Presión Arterial:</strong> {{ $nota->Presion_Arterial ?? '---' }}</p></div>
                    <div class="col-md-3"><p><strong>Frecuencia Cardíaca:</strong> {{ $nota->Frecuencia_Cardiaca ?? '---' }}</p></div>
                </div>
            </div>
        </div>

        <div class="card mb-4 shadow-sm border-0 rounded-4">
            <div class="card-header bg-light fw-bold text-primary">
                <i class="bi bi-heart-pulse"></i> Evaluación Médica
            </div>
            <div class="card-body">
                <p><strong>Exploración Física:</strong></p>
                <p class="ms-3">{{ $nota->Exploracion_Fisica ?? '---' }}</p>

                <p><strong>Diagnóstico:</strong></p>
                <p class="ms-3">{{ $nota->Diagnostico ?? '---' }}</p>

                <p><strong>Tratamiento:</strong></p>
                <p class="ms-3">{{ $nota->Tratamiento ?? '---' }}</p>

                <p><strong>Plan a Seguir:</strong></p>
                <p class="ms-3">{{ $nota->Plan_A_Seguir ?? '---' }}</p>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('notas.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <a href="{{ route('notas.edit', $nota->Id_Nota) }}" class="btn btn-primary">
                <i class="bi bi-pencil-square"></i> Editar Nota
            </a>
        </div>
    </div>
@endsection
