@extends('layouts.app')

@section('titulo', 'Crear Expediente Clínico')
@section('icono')
    <i class="bi bi-folder-plus text-primary"></i>
@endsection

@section('contenido')

<!-- ✅ Mensaje de éxito -->
@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Éxito',
    text: "{{ session('success') }}",
    confirmButtonColor: '#198754'
});
</script>
@endif

<!-- ⚠️ Mensajes de error generales -->
@if($errors->any())
<script>
Swal.fire({
    icon: 'error',
    title: 'Error',
    html: `{!! implode('<br>', $errors->all()) !!}`,
    confirmButtonColor: '#dc3545'
});
</script>
@endif

<div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-folder-plus"></i> Crear Expediente Clínico
    </div>

    <div class="card-body">
        <form id="formExpediente" action="{{ route('expedientes.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <!-- 🔎 Buscar paciente -->
                <div class="col-md-6 position-relative mb-4">
                    <label for="buscar_paciente" class="form-label">Buscar Paciente</label>
                    <input type="text" id="buscar_paciente" class="form-control" placeholder="Nombre o Apellido">
                    <input type="hidden" name="Paciente_Id" id="paciente_id" required>
                    <div id="resultados" class="list-group mt-1 position-absolute w-100 shadow-sm" style="z-index:1050; display:none;"></div>
                </div>

                <!-- 👨‍⚕️ Médico -->
                <div class="col-md-6">
                    <label for="medico" class="form-label">Médico responsable</label>
                    <input type="text" class="form-control" 
                        value="{{ Auth::user()->Nombre ?? Auth::user()->name }} {{ Auth::user()->Apellido ?? '' }}" 
                        readonly>
                </div>
            </div>

            <!-- Campos ocultos -->
            <input type="hidden" name="Fecha_Apertura" value="{{ now() }}">
            <input type="hidden" name="Estado_Expediente" value="Activo">

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('expedientes.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Guardar Expediente
                </button>
            </div>
        </form>
    </div>
</div>

<!-- 🧠 Script de búsqueda y validación -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('buscar_paciente');
    const lista = document.getElementById('resultados');
    const hidden = document.getElementById('paciente_id');

    input.addEventListener('input', async function() {
        const q = this.value.trim();
        if (q.length < 2) { lista.style.display = 'none'; return; }

        try {
            const res = await fetch(`/expedientes/buscar-pacientes?q=${encodeURIComponent(q)}`);
            const data = await res.json();
            lista.innerHTML = '';

            if (data.length > 0) {
                data.forEach(p => {
                    const nombre = `${p.Nombre} ${p.Apellido}`.trim();
                    const item = document.createElement('a');
                    item.href = '#';
                    item.classList.add('list-group-item','list-group-item-action');
                    item.textContent = nombre;

                    item.addEventListener('click', async ev => {
                        ev.preventDefault();
                        input.value = nombre;
                        hidden.value = p.Id_Paciente;
                        lista.style.display = 'none';

                        // ✅ Verificar si ya tiene expediente
                        const check = await fetch(`/verificar-expediente/${p.Id_Paciente}`);
                        const { existe } = await check.json();

                        if (existe) {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Expediente ya existente',
                                text: `El paciente ${nombre} ya cuenta con un expediente clínico.`,
                                confirmButtonColor: '#dc3545'
                            });
                            input.value = ''; 
                            hidden.value = '';
                        }
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

    // Cerrar lista si se hace clic fuera
    document.addEventListener('click', e => { 
        if (!lista.contains(e.target) && e.target !== input) lista.style.display = 'none'; 
    });

    // Confirmación antes de enviar formulario
    document.getElementById('formExpediente').addEventListener('submit', function(ev) {
        ev.preventDefault();
        if (!hidden.value) {
            Swal.fire({
                icon: 'error',
                title: 'Selecciona un paciente',
                text: 'Debes elegir un paciente antes de crear el expediente.',
                confirmButtonColor: '#dc3545'
            });
            return;
        }

        Swal.fire({
            title: '¿Crear expediente clínico?',
            text: 'Confirma que deseas guardar este expediente.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#198754'
        }).then(result => {
            if (result.isConfirmed) this.submit();
        });
    });
});
</script>
@endsection
