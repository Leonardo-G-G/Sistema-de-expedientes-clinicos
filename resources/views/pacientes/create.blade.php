@extends('layouts.app')

@section('titulo', 'Registrar Paciente')

@section('icono')
    <i class="bi bi-person-lines-fill"></i>
@endsection

@section('contenido')
<div class="card">
    <h4 class="mb-3"><i class="bi bi-person-plus"></i> Nuevo Paciente</h4>

    <form action="{{ route('pacientes.store') }}" method="POST">
        @csrf

        <div class="row mb-3">
            <div class="col-md-6">
                <label>Nombre</label>
                <input type="text" name="Nombre" class="form-control" required value="{{ old('Nombre') }}">
                @error('Nombre')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
            <div class="col-md-6">
                <label>Apellido</label>
                <input type="text" name="Apellido" class="form-control" required value="{{ old('Apellido') }}">
                @error('Apellido')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-4">
                <label>Sexo</label>
                <select name="Sexo" class="form-select">
                    <option value="">Selecciona</option>
                    <option value="Masculino" {{ old('Sexo') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                    <option value="Femenino" {{ old('Sexo') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                    <option value="Otro" {{ old('Sexo') == 'Otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
            <div class="col-md-4">
                <label>Fecha de nacimiento</label>
                <input type="date" name="Fecha_Nacimiento" class="form-control" value="{{ old('Fecha_Nacimiento') }}">
            </div>
            <div class="col-md-4">
                <label>Teléfono</label>
                <input type="text" name="Telefono" class="form-control" value="{{ old('Telefono') }}">
            </div>
        </div>

        <div class="mb-3">
            <label>Lugar de origen</label>
            <input type="text" name="Lugar_Origen" class="form-control" value="{{ old('Lugar_Origen') }}">
        </div>

        <div class="mb-3">
            <label>Contacto de emergencia</label>
            <input type="text" name="Contacto_Emergencia" class="form-control" value="{{ old('Contacto_Emergencia') }}">
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('pacientes.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Guardar
            </button>
        </div>
    </form>
</div>
@endsection
