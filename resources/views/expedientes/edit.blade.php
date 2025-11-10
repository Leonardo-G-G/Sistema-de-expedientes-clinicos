@extends('layouts.app')

@section('titulo', 'Editar Expediente Clínico')
@section('icono')
    <i class="bi bi-folder2-open text-primary"></i>
@endsection

@section('contenido')

<!-- ✅ Mensaje de éxito -->
@if(session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'success',
                title: 'Éxito',
                text: "{{ session('success') }}",
                confirmButtonColor: '#198754'
            });
        });
    </script>
@endif

<!-- ⚠️ Mensajes de error -->
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                html: `{!! implode('<br>', $errors->all()) !!}`,
                confirmButtonColor: '#dc3545'
            });
        });
    </script>
@endif

<div class="card shadow-sm">
    <div class="card-header bg-light fw-semibold fs-5 d-flex align-items-center gap-2">
        <i class="bi bi-pencil-square text-primary"></i> Editar Expediente Clínico
    </div>

    <div class="card-body">
        <form action="{{ route('expedientes.update', $expediente->Id_Expediente) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="Paciente_Id" class="form-label fw-semibold">Paciente</label>
                    <select name="Paciente_Id" id="Paciente_Id" class="form-select" required>
                        <option value="">Seleccione un paciente</option>
                        @foreach($pacientes as $paciente)
                            <option value="{{ $paciente->Id_Paciente }}" 
                                {{ $expediente->Paciente_Id == $paciente->Id_Paciente ? 'selected' : '' }}>
                                {{ $paciente->Nombre }} {{ $paciente->Apellido }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-6">
                    <label for="Estado_Expediente" class="form-label fw-semibold">Estado del Expediente</label>
                    <select name="Estado_Expediente" id="Estado_Expediente" class="form-select" required>
                        <option value="Activo" {{ $expediente->Estado_Expediente == 'Activo' ? 'selected' : '' }}>Activo</option>
                        <option value="Inactivo" {{ $expediente->Estado_Expediente == 'Inactivo' ? 'selected' : '' }}>Inactivo</option>
                        <option value="Cerrado" {{ $expediente->Estado_Expediente == 'Cerrado' ? 'selected' : '' }}>Cerrado</option>
                    </select>
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('expedientes.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Guardar cambios
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
