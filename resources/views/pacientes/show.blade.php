@extends('layouts.app')

@section('titulo', 'Paciente - ' . $paciente->Nombre . ' ' . $paciente->Apellido)
@section('icono')
    <i class="bi bi-person-vcard text-primary"></i>
@endsection
@section('pacientes_active', 'active')

@section('contenido')
    <div class="card mb-4">
        <div class="card-header">
            <i class="bi bi-info-circle"></i> Información Personal
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <p><strong>Nombre:</strong> {{ $paciente->Nombre }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Apellido:</strong> {{ $paciente->Apellido }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Sexo:</strong> {{ $paciente->Sexo ?? '---' }}</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <p><strong>Teléfono:</strong> {{ $paciente->Telefono ?? '---' }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Fecha de Nacimiento:</strong> {{ $paciente->Fecha_Nacimiento ?? '---' }}</p>
                </div>
                <div class="col-md-4">
                    <p><strong>Edad:</strong> {{ $paciente->edad ?? '---' }} años</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <p><strong>Lugar de Origen:</strong> {{ $paciente->Lugar_Origen ?? '---' }}</p>
                </div>
                <div class="col-md-6">
                    <p><strong>Contacto de Emergencia:</strong> {{ $paciente->Contacto_Emergencia ?? '---' }}</p>
                </div>
            </div>

            <hr>
            <p><strong>Expediente:</strong> {{ $paciente->expediente->Id_Expediente ?? 'No registrado' }}</p>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <a href="{{ route('pacientes.edit', $paciente->Id_Paciente) }}" class="btn btn-primary">
            <i class="bi bi-pencil-square"></i> Editar Paciente
        </a>
    </div>
@endsection
