@extends('layouts.app')

@section('titulo', 'Notas Médicas')
@section('icono')
    <i class="bi bi-journal-medical text-primary"></i>
@endsection

@section('contenido')

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

<style>
    /* --- Diseño moderno clínico --- */
    .header-clinica {
        background: linear-gradient(135deg, #e8f2ff, #ffffff);
        border-bottom: 2px solid #d9e7ff;
        padding: 20px 25px;
        border-radius: 10px 10px 0 0;
    }

    .search-large {
        width: 250px !important;
        height: 48px !important;
        font-size: 1rem;
        border-radius: 8px;
    }

    .btn-search-modern {
        height: 48px !important;
        border-radius: 8px;
        padding: 0 20px;
    }

    .table-modern thead {
        background: #e8f2ff;
    }

    .table-modern tbody tr:hover {
        background: #f8fbff;
    }

    .input-date {
        width: 180px !important;
        height: 48px !important;
        border-radius: 8px;
    }
</style>

<div class="card shadow-sm">

    <!-- Encabezado moderno -->
    <div class="header-clinica d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <h5 class="fw-bold text-primary">
            <i class="bi bi-list-ul"></i> Listado de Notas Médicas
        </h5>

        <div class="d-flex flex-column flex-md-row align-items-center gap-2">

            <a href="{{ route('notas.create') }}" class="btn btn-primary px-2">
                <i class="bi bi-plus-circle"></i> Nueva nota
            </a>

            <!-- Buscador grande + filtro por fecha -->
            <form action="{{ route('notas.index') }}" method="GET" class="d-flex gap-2">
                <input type="text" 
                       name="search" 
                       class="form-control search-large shadow-sm" 
                       placeholder="Buscar paciente..." 
                       value="{{ request('search') }}">

                <input type="date" 
                       name="fecha" 
                       class="form-control input-date shadow-sm" 
                       value="{{ request('fecha') }}">

                <button type="submit" class="btn btn-outline-primary btn-search-modern shadow-sm">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>
    </div>

    <!-- Tabla -->
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-modern table-striped align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Paciente</th>
                        <th>Fecha</th>
                        <th>Peso (kg)</th>
                        <th>Talla (m)</th>
                        <th>Presión</th>
                        <th>Frecuencia Cardíaca</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($notas as $nota)
                        <tr>
                            <td>{{ $nota->Id_Nota }}</td>
                            <td>
                                {{ optional(optional($nota->historiaClinica)->expediente->paciente)->Nombre ?? '-' }}
                                {{ optional(optional($nota->historiaClinica)->expediente->paciente)->Apellido ?? '' }}
                            </td>
                            <td>{{ $nota->Fecha }} {{ $nota->Hora ?? '' }}</td>
                            <td>{{ $nota->Peso ?? '-' }}</td>
                            <td>{{ $nota->Talla ?? '-' }}</td>
                            <td>{{ $nota->Presion_Arterial ?? '-' }}</td>
                            <td>{{ $nota->Frecuencia_Cardiaca ?? '-' }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('notas.show', $nota->Id_Nota) }}" 
                                       class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('notas.edit', $nota->Id_Nota) }}" 
                                       class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Editar nota">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('notas.destroy', $nota->Id_Nota) }}" method="POST" class="d-inline eliminar-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-eliminar" data-bs-toggle="tooltip" title="Eliminar nota">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-3">No se encontraron registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $notas->appends(request()->all())->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- SweetAlert eliminar -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            let form = this.closest('.eliminar-form');

            Swal.fire({
                title: '¿Desea eliminar esta nota médica?',
                text: 'Esta acción no se puede deshacer.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        });
    });
});
</script>

@endsection
