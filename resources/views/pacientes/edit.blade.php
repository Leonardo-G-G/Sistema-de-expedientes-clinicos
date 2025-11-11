@extends('layouts.app')

@section('titulo', 'Editar Paciente')

@section('icono')
    <i class="bi bi-person-lines-fill"></i>
@endsection

@section('contenido')
<div class="card">
    <h4 class="mb-3"><i class="bi bi-pencil-square"></i> Editar Paciente</h4>

    <form action="{{ route('pacientes.update', $paciente->Id_Paciente) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Nombre</label>
                <input type="text" name="Nombre" value="{{ old('Nombre', $paciente->Nombre) }}" class="form-control" required>
                @error('Nombre')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6">
                <label>Apellido</label>
                <input type="text" name="Apellido" value="{{ old('Apellido', $paciente->Apellido) }}" class="form-control" required>
                @error('Apellido')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Sexo</label>
                <select name="Sexo" class="form-select" required>
                    <option value="">Selecciona</option>
                    <option value="Masculino" {{ $paciente->Sexo == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Femenino" {{ $paciente->Sexo == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                    <option value="Otro" {{ $paciente->Sexo == 'Otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>

            <div class="col-md-4">
                <label>Fecha de nacimiento</label>
                <input type="date" name="Fecha_Nacimiento" value="{{ old('Fecha_Nacimiento', $paciente->Fecha_Nacimiento) }}" class="form-control">
            </div>

            <div class="col-md-4">
                <label>Teléfono</label>
                <input type="text" name="Telefono" value="{{ old('Telefono', $paciente->Telefono) }}" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label>Lugar de origen</label>
            <input type="text" name="Lugar_Origen" value="{{ old('Lugar_Origen', $paciente->Lugar_Origen) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label>Contacto de emergencia</label>
            <input type="text" name="Contacto_Emergencia" value="{{ old('Contacto_Emergencia', $paciente->Contacto_Emergencia) }}" class="form-control">
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Guardar cambios
            </button>
        </div>
    </form>
</div>

@if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#198754' // verde Bootstrap
            });
        });
    </script>
@endif
@endsection
