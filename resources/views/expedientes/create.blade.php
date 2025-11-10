@extends('layouts.app')

@section('titulo', 'Crear Expediente Clínico')
@section('icono')
    <i class="bi bi-folder-plus text-primary"></i>
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

<!-- ⚠️ Mensajes de error (incluye expediente existente) -->
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

<!-- ⚠️ Mensaje específico: expediente clínico ya existente -->
@if ($errors->has('Paciente_Id'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                icon: 'warning',
                title: 'Expediente ya existente',
                text: "{{ $errors->first('Paciente_Id') }}",
                confirmButtonColor: '#dc3545'
            });
        });
    </script>
@endif

<div class="card shadow-sm">
    <div class="card-header bg-light fw-semibold fs-5 d-flex align-items-center gap-2">
        <i class="bi bi-folder-plus text-primary"></i> Crear Expediente Clínico
    </div>

    <div class="card-body">
        <form action="{{ route('expedientes.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <!-- Campo de búsqueda dinámica -->
                <div class="col-md-6 position-relative">
                    <label for="buscar_paciente" class="form-label">Paciente</label>
                    <input type="text" id="buscar_paciente" class="form-control"
                        placeholder="Escribe el nombre o apellido del paciente..."
                        value="{{ old('buscar_paciente') }}">
                    <input type="hidden" name="Paciente_Id" id="paciente_id"
                        value="{{ old('Paciente_Id') }}" required>
                    <div id="resultados" class="list-group mt-1 shadow-sm"
                        style="display:none; position:absolute; width:100%; z-index:1050;"></div>
                </div>

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

<!-- 🔎 Script búsqueda dinámica -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('buscar_paciente');
    const lista = document.getElementById('resultados');
    const hidden = document.getElementById('paciente_id');
    let timeout = null;

    input.addEventListener('input', function() {
        const q = this.value.trim();
        clearTimeout(timeout);

        if (q.length < 2) {
            lista.style.display = 'none';
            return;
        }

        timeout = setTimeout(() => {
            fetch(`{{ route('expedientes.buscarPacientes') }}?q=${encodeURIComponent(q)}`)
                .then(res => res.json())
                .then(data => {
                    lista.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(p => {
                            const item = document.createElement('a');
                            item.href = '#';
                            item.classList.add('list-group-item', 'list-group-item-action');
                            item.textContent = `${p.Nombre} ${p.Apellido}`;
                            item.addEventListener('click', e => {
                                e.preventDefault();
                                input.value = `${p.Nombre} ${p.Apellido}`;
                                hidden.value = p.Id_Paciente;
                                lista.style.display = 'none';
                            });
                            lista.appendChild(item);
                        });
                        lista.style.display = 'block';
                    } else {
                        lista.style.display = 'none';
                    }
                })
                .catch(() => lista.style.display = 'none');
        }, 300);
    });

    document.addEventListener('click', e => {
        if (!lista.contains(e.target) && e.target !== input) {
            lista.style.display = 'none';
        }
    });
});
</script>

@endsection
