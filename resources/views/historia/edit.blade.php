@extends('layouts.app')

@section('titulo', 'Editar Historia Clínica')
@section('icono')
    <i class="bi bi-pencil-square text-warning"></i>
@endsection

@section('contenido')

@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', () => {
    Swal.fire({
        icon: 'success',
        title: 'Éxito',
        text: '{{ session("success") }}',
        confirmButtonColor: '#198754'
    });
});
</script>
@endif

@if($errors->any())
<script>
document.addEventListener('DOMContentLoaded', () => {
    Swal.fire({
        icon: 'error',
        title: 'Error',
        html: `{!! implode('<br>', $errors->all()) !!}`,
        confirmButtonColor: '#dc3545'
    });
});
</script>
@endif

<form id="formHistoria" action="{{ route('historia.update', $historia->Id_Historia) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- DATOS GENERALES -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-person-lines-fill"></i> Datos Generales
        </div>
        <div class="card-body">
            <div class="col-md-6 mb-3">
                <label for="buscar_paciente" class="form-label">Expediente</label>
                <input type="text" class="form-control" disabled
                    value="Expediente #{{ $historia->expediente->Id_Expediente }} - {{ optional($historia->expediente->paciente)->Nombre }} {{ optional($historia->expediente->paciente)->Apellido }}">
                <input type="hidden" name="Expediente_Id" value="{{ $historia->Expediente_Id }}">
            </div>
        </div>
    </div>

    <!-- ANTECEDENTES HEREDOFAMILIARES -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-heart-pulse"></i> Antecedentes Heredofamiliares
        </div>
        <div class="card-body row">
            @php $h = $historia->heredofamiliares ?? []; @endphp
            @foreach(['Diabetes','Hipertension','Cancer'] as $campo)
                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ $campo }}</label>
                    <select name="heredofamiliares[{{ $campo }}]" class="form-select">
                        <option value="0" {{ ($h[$campo] ?? 0) == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ ($h[$campo] ?? 0) == 1 ? 'selected' : '' }}>Sí</option>
                    </select>
                </div>
            @endforeach
            <div class="col-md-6 mb-3">
                <label class="form-label">Enfermedades Crónicas</label>
                <input type="text" name="heredofamiliares[Enfermedades_Cronicas]" class="form-control" value="{{ $h['Enfermedades_Cronicas'] ?? '' }}">
            </div>
            <div class="col-md-6 mb-3">
                <label class="form-label">Otros</label>
                <input type="text" name="heredofamiliares[Otros]" class="form-control" value="{{ $h['Otros'] ?? '' }}">
            </div>
        </div>
    </div>

    <!-- ANTECEDENTES NO PATOLÓGICOS -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-hospital"></i> Antecedentes No Patológicos
        </div>
        <div class="card-body row">
            @php $np = $historia->noPatologicos ?? []; @endphp
            @foreach(['Tipo_Vivienda','Religion','Alimentacion','Actividad_Fisica'] as $campo)
                <div class="col-md-6 mb-3">
                    <label class="form-label">{{ str_replace('_',' ',$campo) }}</label>
                    <input type="text" name="no_patologicos[{{ $campo }}]" class="form-control" value="{{ $np[$campo] ?? '' }}">
                </div>
            @endforeach
            @foreach(['Tabaquismo','Alcoholismo','Drogas'] as $campo)
                <div class="col-md-4 mb-3">
                    <label class="form-label">{{ $campo }}</label>
                    <select name="no_patologicos[{{ $campo }}]" class="form-select">
                        <option value="0" {{ ($np[$campo] ?? 0) == 0 ? 'selected' : '' }}>No</option>
                        <option value="1" {{ ($np[$campo] ?? 0) == 1 ? 'selected' : '' }}>Sí</option>
                    </select>
                </div>
            @endforeach
        </div>
    </div>

    <!-- ANTECEDENTES PATOLÓGICOS -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-clipboard2-pulse"></i> Antecedentes Patológicos
        </div>
        <div class="card-body">
            <label class="form-label">Descripción</label>
            <textarea name="patologicos[Descripcion]" class="form-control" rows="3">{{ $historia->patologicos['Descripcion'] ?? '' }}</textarea>
        </div>
    </div>

    <!-- GINECOOBSTÉTRICOS -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-gender-female"></i> Antecedentes Ginecoobstétricos
        </div>
        <div class="card-body row">
            @php $g = $historia->ginecoobstetricos ?? []; @endphp
            <div class="col-md-3 mb-3">
                <label class="form-label">Menarca (Edad)</label>
                <input type="number" name="ginecoobstetricos[Menarca_Edad]" class="form-control" value="{{ $g['Menarca_Edad'] ?? '' }}">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Tipo de Ciclo</label>
                <input type="text" name="ginecoobstetricos[Tipo_Ciclo]" class="form-control" value="{{ $g['Tipo_Ciclo'] ?? '' }}">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Ciclos Dolorosos</label>
                <select name="ginecoobstetricos[Ciclos_Dolor]" class="form-select">
                    <option value="1" {{ ($g['Ciclos_Dolor'] ?? 0) == 1 ? 'selected' : '' }}>Sí</option>
                    <option value="0" {{ ($g['Ciclos_Dolor'] ?? 0) == 0 ? 'selected' : '' }}>No</option>
                </select>
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Última Regla</label>
                <input type="date" name="ginecoobstetricos[Ultima_Regla]" class="form-control" value="{{ $g['Ultima_Regla'] ?? '' }}">
            </div>
            <div class="col-md-3 mb-3">
                <label class="form-label">Inicio Vida Sexual</label>
                <input type="number" name="ginecoobstetricos[Inicio_Vida_Sexual]" class="form-control" value="{{ $g['Inicio_Vida_Sexual'] ?? '' }}">
            </div>
            @foreach(['Gestaciones','Partos','Abortos','Cesareas'] as $campo)
                <div class="col-md-3 mb-3">
                    <label class="form-label">{{ $campo }}</label>
                    <input type="number" name="ginecoobstetricos[{{ $campo }}]" class="form-control" value="{{ $g[$campo] ?? 0 }}">
                </div>
            @endforeach
        </div>
    </div>

    <!-- NOTA MÉDICA -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <i class="bi bi-journal-medical"></i> Nota Médica
        </div>
        <div class="card-body row">
            @php $nota = $historia->notaMedicas->first(); @endphp
            <input type="hidden" name="nota_medica[Id_Nota]" value="{{ $nota->Id_Nota ?? '' }}">

            <div class="col-md-3 mb-3">
                <label class="form-label">Peso (kg)</label>
                <input type="number" step="0.1" name="nota_medica[Peso]" class="form-control" value="{{ old('nota_medica.Peso', $nota->Peso ?? '') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Talla (m)</label>
                <input type="number" step="0.01" name="nota_medica[Talla]" class="form-control" value="{{ old('nota_medica.Talla', $nota->Talla ?? '') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Presión Arterial</label>
                <input type="text" name="nota_medica[Presion_Arterial]" class="form-control" value="{{ old('nota_medica.Presion_Arterial', $nota->Presion_Arterial ?? '') }}">
            </div>

            <div class="col-md-3 mb-3">
                <label class="form-label">Frecuencia Cardíaca</label>
                <input type="number" name="nota_medica[Frecuencia_Cardiaca]" class="form-control" value="{{ old('nota_medica.Frecuencia_Cardiaca', $nota->Frecuencia_Cardiaca ?? '') }}">
            </div>

            <div class="col-md-12 mb-3">
                <label class="form-label">Exploración Física</label>
                <textarea name="nota_medica[Exploracion_Fisica]" class="form-control" rows="3">{{ old('nota_medica.Exploracion_Fisica', $nota->Exploracion_Fisica ?? '') }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Diagnóstico</label>
                <textarea name="nota_medica[Diagnostico]" class="form-control" rows="3">{{ old('nota_medica.Diagnostico', $nota->Diagnostico ?? '') }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Tratamiento</label>
                <textarea name="nota_medica[Tratamiento]" class="form-control" rows="3">{{ old('nota_medica.Tratamiento', $nota->Tratamiento ?? '') }}</textarea>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Plan a Seguir</label>
                <textarea name="nota_medica[Plan_A_Seguir]" class="form-control" rows="3">{{ old('nota_medica.Plan_A_Seguir', $nota->Plan_A_Seguir ?? '') }}</textarea>
            </div>
        </div>
    </div>

    <!-- BOTONES -->
    <div class="d-flex justify-content-between mt-3">
        <a href="{{ route('historia.index') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <button type="submit" class="btn btn-primary">
            <i class="bi bi-save"></i> Actualizar Historia Clínica
        </button>
    </div>
</form>

<script>
document.getElementById('formHistoria').addEventListener('submit', function(e) {
    e.preventDefault();
    Swal.fire({
        title: '¿Guardar cambios?',
        text: 'Se actualizará la información de la historia clínica.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, actualizar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#0d6efd'
    }).then(result => {
        if (result.isConfirmed) this.submit();
    });
});
</script>

@endsection
