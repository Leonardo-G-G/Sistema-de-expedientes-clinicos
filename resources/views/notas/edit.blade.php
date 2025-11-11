@extends('layouts.app')

@section('icono')
    <i class="bi bi-pencil-square text-primary"></i>
@endsection

@section('titulo', 'Editar Nota Médica')

@section('contenido')
<div class="container mt-4">
    <form action="{{ route('notas.update', $nota->Id_Nota) }}" method="POST" class="card p-4 shadow-sm" id="formNota">
        @csrf
        @method('PUT')

        <!-- 🔍 Buscar historia -->
        <div class="mb-3 position-relative">
            <label class="form-label">Buscar Historia Clínica</label>
            <input type="text" id="buscar_historia" class="form-control"
                value="{{ $nota->historiaClinica->expediente->paciente->Nombre ?? '' }} {{ $nota->historiaClinica->expediente->paciente->Apellido ?? '' }}"
                placeholder="Nombre o Apellido del paciente">
            <input type="hidden" name="Historia_Id" id="Historia_Id" value="{{ $nota->Historia_Id }}" required>
            <div id="resultadosHistorias" class="list-group position-absolute w-100 mt-1 shadow-sm" style="z-index:1050; display:none;"></div>
        </div>

        <!-- Fecha y hora -->
        <input type="hidden" name="Fecha" value="{{ now()->format('Y-m-d') }}">
        <input type="hidden" name="Hora" value="{{ now()->format('H:i') }}">

        <!-- 🩺 Datos vitales -->
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Peso (kg)</label>
                <input type="number" step="0.1" name="Peso" class="form-control" value="{{ old('Peso', $nota->Peso) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Talla (m)</label>
                <input type="number" step="0.01" name="Talla" class="form-control" value="{{ old('Talla', $nota->Talla) }}">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Presión Arterial</label>
                <input type="text" name="Presion_Arterial" class="form-control" value="{{ old('Presion_Arterial', $nota->Presion_Arterial) }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">Frecuencia Cardíaca</label>
                <input type="number" name="Frecuencia_Cardiaca" class="form-control" value="{{ old('Frecuencia_Cardiaca', $nota->Frecuencia_Cardiaca) }}">
            </div>
        </div>

        <!-- 🧍 Exploración física -->
        <div class="mb-3">
            <label class="form-label">Exploración Física</label>
            <textarea name="Exploracion_Fisica" rows="3" class="form-control">{{ old('Exploracion_Fisica', $nota->Exploracion_Fisica) }}</textarea>
        </div>

        <!-- 🧠 Diagnóstico -->
        <div class="mb-3">
            <label class="form-label">Diagnóstico</label>
            <textarea name="Diagnostico" rows="3" class="form-control">{{ old('Diagnostico', $nota->Diagnostico) }}</textarea>
        </div>

        <!-- 💊 Tratamiento -->
        <div class="mb-3">
            <label class="form-label">Tratamiento</label>
            <textarea name="Tratamiento" rows="3" class="form-control">{{ old('Tratamiento', $nota->Tratamiento) }}</textarea>
        </div>

        <!-- 📅 Plan a seguir -->
        <div class="mb-3">
            <label class="form-label">Plan a Seguir</label>
            <textarea name="Plan_A_Seguir" rows="3" class="form-control">{{ old('Plan_A_Seguir', $nota->Plan_A_Seguir) }}</textarea>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('notas.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Actualizar Nota Médica
            </button>
        </div>
    </form>
</div>

<!-- ✅ SweetAlert2 para éxito -->
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    Swal.fire({
        icon: 'success',
        title: '¡Nota médica actualizada!',
        text: '{{ session('success') }}',
        confirmButtonColor: '#198754'
    });
});
</script>
@endif

<!-- ❌ SweetAlert2 para errores -->
@if($errors->any())
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

<!-- 🧠 Script búsqueda y confirmación -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('buscar_historia');
    const lista = document.getElementById('resultadosHistorias');
    const hidden = document.getElementById('Historia_Id');

    input.addEventListener('input', async function() {
        const q = this.value.trim();
        if (q.length < 2) { lista.style.display = 'none'; return; }

        try {
            const res = await fetch(`/buscar-historias?q=${encodeURIComponent(q)}`);
            const data = await res.json();
            lista.innerHTML = '';

            if (data.length > 0) {
                data.forEach(h => {
                    const item = document.createElement('a');
                    item.href = '#';
                    item.classList.add('list-group-item', 'list-group-item-action');
                    item.textContent = `${h.Nombre} ${h.Apellido} — Historia #${h.Id_Historia}`;
                    item.addEventListener('click', ev => {
                        ev.preventDefault();
                        input.value = `${h.Nombre} ${h.Apellido}`;
                        hidden.value = h.Id_Historia;
                        lista.style.display = 'none';
                    });
                    lista.appendChild(item);
                });
                lista.style.display = 'block';
            } else {
                lista.innerHTML = '<div class="list-group-item text-muted">No se encontraron resultados</div>';
                lista.style.display = 'block';
            }
        } catch (err) {
            console.error(err);
            lista.style.display = 'none';
        }
    });

    document.addEventListener('click', e => {
        if (!lista.contains(e.target) && e.target !== input)
            lista.style.display = 'none';
    });

    // ⚠️ Confirmar antes de actualizar nota
    document.getElementById('formNota').addEventListener('submit', function(ev) {
        ev.preventDefault();
        if (!hidden.value) {
            Swal.fire({
                icon: 'error',
                title: 'Selecciona una historia clínica',
                text: 'Debes elegir una historia clínica antes de actualizar la nota médica.',
                confirmButtonColor: '#dc3545'
            });
            return;
        }

        Swal.fire({
            title: '¿Actualizar nota médica?',
            text: 'Confirma que deseas guardar los cambios realizados.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, actualizar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#198754'
        }).then(result => {
            if (result.isConfirmed) this.submit();
        });
    });
});
</script>
@endsection
