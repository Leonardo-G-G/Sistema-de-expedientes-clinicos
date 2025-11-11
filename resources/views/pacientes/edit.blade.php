@extends('layouts.app')

@section('titulo', 'Editar Paciente')

@section('icono')
    <i class="bi bi-person-lines-fill"></i>
@endsection

@section('contenido')
<div class="card p-4 shadow-sm">

    {{-- SweetAlert de éxito --}}
    @if (session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#198754', // verde Bootstrap
                    timer: 2500,
                    timerProgressBar: true
                });
            });
        </script>
    @endif

    <form action="{{ route('pacientes.update', $paciente->Id_Paciente) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">Nombre</label>
                <input type="text" name="Nombre" value="{{ old('Nombre', $paciente->Nombre) }}" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">Apellido</label>
                <input type="text" name="Apellido" value="{{ old('Apellido', $paciente->Apellido) }}" class="form-control" required>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">Sexo</label>
                <select name="Sexo" class="form-select" required>
                    <option value="">Selecciona</option>
                    <option value="Masculino" {{ $paciente->Sexo == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Femenino" {{ $paciente->Sexo == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                    <option value="Otro" {{ $paciente->Sexo == 'Otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Fecha de nacimiento</label>
                <input type="date" name="Fecha_Nacimiento" value="{{ old('Fecha_Nacimiento', $paciente->Fecha_Nacimiento) }}" class="form-control">
            </div>

            <div class="col-md-4">
                <label class="form-label fw-semibold">Teléfono</label>
                <input type="text" name="Telefono" value="{{ old('Telefono', $paciente->Telefono) }}" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Lugar de origen</label>
            <input type="text" name="Lugar_Origen" value="{{ old('Lugar_Origen', $paciente->Lugar_Origen) }}" class="form-control">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">Contacto de emergencia</label>
            <input type="text" name="Contacto_Emergencia" value="{{ old('Contacto_Emergencia', $paciente->Contacto_Emergencia) }}" class="form-control">
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="{{ route('pacientes.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Guardar cambios
            </button>
        </div>
    </form>
</div>
@endsection
