@extends('layouts.app')

@section('titulo', 'Perfil del Usuario')
@section('icono')
    <i class="bi bi-person-badge text-primary"></i>
@endsection
@section('perfil_active', 'active')

@section('contenido')
    <div class="container">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0 fw-semibold fs-5 text-primary">
                <i class="bi bi-person-lines-fill"></i> Información del Usuario
            </div>

            <div class="card-body">
                <p><strong>Nombre:</strong> {{ $usuario->Nombre }} {{ $usuario->Apellido }}</p>
                <p><strong>Correo electrónico:</strong> {{ $usuario->Correo_Electronico }}</p>
                <p><strong>Especialidad:</strong> {{ $usuario->Especialidad ?? 'No especificada' }}</p>

                <div class="text-center mt-4">
                    <a href="{{ route('usuario.editar') }}" class="btn btn-primary">
                        <i class="bi bi-pencil-square"></i> Editar Perfil
                    </a>
                </div>
            </div>
        </div>

        
    </div>
@endsection
