@extends('layouts.app')

@section('titulo', 'Registrar Historia Clínica')
@section('icono')
    <i class="bi bi-file-earmark-medical text-primary"></i>
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

<form id="formHistoria" action="{{ route('historia.store') }}" method="POST">
@csrf

<!-- Datos Generales -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-person-lines-fill"></i> Datos Generales
    </div>
    <div class="card-body">
        <div class="col-md-6 position-relative mb-4">
            <label for="buscar_paciente" class="form-label">Buscar Paciente</label>
            <input type="text" id="buscar_paciente" class="form-control" placeholder="Nombre o Apellido">
            <input type="hidden" name="Expediente_Id" id="Expediente_Id" required>
            <div id="resultados" class="list-group mt-1 position-absolute w-100" style="z-index:1050; display:none;"></div>
        </div>
    </div>
</div>

<!-- Antecedentes Heredofamiliares -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-heart-pulse"></i> Antecedentes Heredofamiliares
    </div>
    <div class="card-body row">
        @foreach(['Diabetes','Hipertension','Cancer'] as $campo)
            <div class="col-md-4 mb-3">
                <label class="form-label">{{ $campo }}</label>
                <select name="heredofamiliares[{{ $campo }}]" class="form-select">
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                </select>
            </div>
        @endforeach
        <div class="col-md-6 mb-3">
            <label class="form-label">Enfermedades Crónicas</label>
            <input type="text" name="heredofamiliares[Enfermedades_Cronicas]" class="form-control">
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Otros</label>
            <input type="text" name="heredofamiliares[Otros]" class="form-control">
        </div>
    </div>
</div>

<!-- Antecedentes No Patológicos -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-hospital"></i> Antecedentes No Patológicos
    </div>
    <div class="card-body row">
        @foreach(['Tipo_Vivienda','Religion','Alimentacion','Actividad_Fisica'] as $campo)
            <div class="col-md-6 mb-3">
                <label class="form-label">{{ str_replace('_',' ',$campo) }}</label>
                <input type="text" name="no_patologicos[{{ $campo }}]" class="form-control">
            </div>
        @endforeach
        @foreach(['Tabaquismo','Alcoholismo','Drogas'] as $campo)
            <div class="col-md-4 mb-3">
                <label class="form-label">{{ $campo }}</label>
                <select name="no_patologicos[{{ $campo }}]" class="form-select">
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                </select>
            </div>
        @endforeach
    </div>
</div>

<!-- Antecedentes Patológicos -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-clipboard2-pulse"></i> Antecedentes Patológicos
    </div>
    <div class="card-body">
        <label class="form-label">Descripción</label>
        <textarea name="patologicos[Descripcion]" class="form-control" rows="3"></textarea>
    </div>
</div>

<!-- Ginecoobstétricos -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-gender-female"></i> Antecedentes Ginecoobstétricos
    </div>
    <div class="card-body row">
        <div class="col-md-3 mb-3">
            <label class="form-label">Menarca (Edad)</label>
            <input type="number" name="ginecoobstetricos[Menarca_Edad]" class="form-control">
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Tipo de Ciclo</label>
            <input type="text" name="ginecoobstetricos[Tipo_Ciclo]" class="form-control">
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Ciclos Dolorosos</label>
            <select name="ginecoobstetricos[Ciclos_Dolor]" class="form-select">
                <option value="1">Sí</option>
                <option value="0">No</option>
            </select>
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Última Regla</label>
            <input type="date" name="ginecoobstetricos[Ultima_Regla]" class="form-control">
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Inicio Vida Sexual</label>
            <input type="number" name="ginecoobstetricos[Inicio_Vida_Sexual]" class="form-control">
        </div>
        @foreach(['Gestaciones','Partos','Abortos','Cesareas'] as $campo)
            <div class="col-md-3 mb-3">
                <label class="form-label">{{ $campo }}</label>
                <input type="number" name="ginecoobstetricos[{{ $campo }}]" class="form-control" value="0">
            </div>
        @endforeach
    </div>
</div>

<!-- Nota Médica -->
<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-journal-medical"></i> Nota Médica
    </div>
    <div class="card-body row">
        <div class="col-md-3 mb-3">
            <label class="form-label">Peso (kg)</label>
            <input type="number" step="0.1" name="nota_medica[Peso]" class="form-control">
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Talla (m)</label>
            <input type="number" step="0.01" name="nota_medica[Talla]" class="form-control" placeholder="Ej. 1.70">
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Presión Arterial</label>
            <input type="text" name="nota_medica[Presion_Arterial]" class="form-control">
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Frecuencia Cardíaca</label>
            <input type="number" name="nota_medica[Frecuencia_Cardiaca]" class="form-control">
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">Exploración Física</label>
            <textarea name="nota_medica[Exploracion_Fisica]" class="form-control" rows="3"></textarea>
        </div>
        <div class="col-md-12 mb-3">
            <label class="form-label">Diagnóstico</label>
            <textarea name="nota_medica[Diagnostico]" class="form-control" rows="3"></textarea>
        </div>
        <div class="col-md-12 mb-3">
            <label class="form-label">Tratamiento</label>
            <textarea name="nota_medica[Tratamiento]" class="form-control" rows="3"></textarea>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Plan a Seguir</label>
            <textarea name="nota_medica[Plan_A_Seguir]" class="form-control" rows="3"></textarea>
        </div>
    </div>
</div>

<!-- Botones -->
<div class="d-flex justify-content-between mt-3">
    <a href="{{ route('historia.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Registrar Historia Clínica
    </button>
</div>

</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('buscar_paciente');
    const lista = document.getElementById('resultados');
    const hidden = document.getElementById('Expediente_Id');

    input.addEventListener('input', async function() {
        const q = this.value.trim();
        if (q.length < 2) { lista.style.display = 'none'; return; }

        try {
            const res = await fetch(`/expedientes/buscar-expedientes?q=${encodeURIComponent(q)}`);
            const data = await res.json();
            lista.innerHTML = '';
            if (data.length > 0) {
                data.forEach(e => {
                    const nombre = `${e.Nombre} ${e.Apellido}`.trim();
                    const item = document.createElement('a');
                    item.href = '#';
                    item.classList.add('list-group-item','list-group-item-action');
                    item.textContent = `${nombre} — Expediente #${e.Id_Expediente}`;
                    item.addEventListener('click', async ev => {
                        ev.preventDefault();
                        input.value = nombre;
                        lista.style.display = 'none';
                        hidden.value = e.Id_Expediente;
                        const check = await fetch(`/verificar-historia/${e.Id_Expediente}`);
                        const { existe } = await check.json();
                        if (existe) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Ya existe una historia clínica',
                                text: `El expediente #${e.Id_Expediente} ya tiene una historia registrada.`
                            });
                            input.value = ''; hidden.value = '';
                        }
                    });
                    lista.appendChild(item);
                });
                lista.style.display = 'block';
            } else {
                lista.innerHTML = '<div class="list-group-item text-muted">No se encontraron resultados</div>';
                lista.style.display = 'block';
            }
        } catch (err) { console.error(err); lista.style.display = 'none'; }
    });

    document.addEventListener('click', e => { 
        if (!lista.contains(e.target) && e.target !== input) lista.style.display = 'none'; 
    });

    // Confirmar antes de enviar el formulario
    document.getElementById('formHistoria').addEventListener('submit', function(ev) {
        ev.preventDefault();
        if (!hidden.value) {
            Swal.fire({
                icon: 'error',
                title: 'Selecciona un paciente',
                text: 'Debes elegir un expediente antes de registrar la historia clínica.'
            });
            return;
        }
        Swal.fire({
            title: '¿Registrar historia clínica?',
            text: 'Confirma que deseas guardar esta información.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#0d6efd'
        }).then(result => {
            if (result.isConfirmed) this.submit();
        });
    });
});
</script>

@endsection
