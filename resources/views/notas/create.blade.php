@extends('layouts.app')

@section('titulo', 'Registrar Nota Médica')
@section('icono')
    <i class="bi bi-journal-medical text-primary"></i>
@endsection
@section('notas_active', 'active')

@section('contenido')
    <h4 class="mb-4"><i class="bi bi-journal-medical"></i> Registrar Nota Médica</h4>

    <form action="{{ route('notas.store') }}" method="POST" class="card p-4 shadow-sm" id="formNota">
        @csrf

        
        <div class="mb-3 position-relative">
            <label class="form-label">Buscar Historia Clínica</label>
            <input type="text" id="buscar_historia" class="form-control" placeholder="Nombre o Apellido del paciente">
            <input type="hidden" name="Historia_Id" id="Historia_Id" required>
            <div id="resultadosHistorias" class="list-group position-absolute w-100 mt-1"
                style="z-index:1050; display:none;"></div>
        </div>

        <input type="hidden" name="Fecha" value="{{ now()->format('Y-m-d') }}">
        <input type="hidden" name="Hora" value="{{ now()->format('H:i') }}">

       
        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Peso (kg)</label>
                <input type="number" step="0.1" name="Peso" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Talla (m)</label>
                <input type="number" step="0.01" name="Talla" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Presión Arterial</label>
                <input type="text" name="Presion_Arterial" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Frecuencia Cardíaca</label>
                <input type="number" name="Frecuencia_Cardiaca" class="form-control">
            </div>
        </div>

       
        <div class="mb-3">
            <label class="form-label">Exploración Física</label>
            <textarea name="Exploracion_Fisica" rows="3" class="form-control"></textarea>
        </div>

      
        <div class="mb-3">
            <label class="form-label">Diagnóstico</label>
            <textarea name="Diagnostico" rows="3" class="form-control"></textarea>
        </div>

        
        <div class="mb-3">
            <label class="form-label">Tratamiento</label>
            <textarea name="Tratamiento" rows="3" class="form-control"></textarea>
        </div>

        
        <div class="mb-3">
            <label class="form-label">Plan a Seguir</label>
            <textarea name="Plan_A_Seguir" rows="3" class="form-control"></textarea>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('notas.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Volver
            </a>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-save"></i> Guardar Nota Médica
            </button>
        </div>
    </form>
@endsection

@push('scripts')
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

    document.getElementById('formNota').addEventListener('submit', function(ev) {
        if (!hidden.value) {
            ev.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Selecciona una historia clínica',
                text: 'Debes elegir una historia clínica antes de registrar la nota médica.'
            });
        }
    });
});
</script>
@endpush
