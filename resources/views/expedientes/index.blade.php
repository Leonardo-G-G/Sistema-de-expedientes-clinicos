@extends('layouts.app')

@section('titulo', 'Expedientes')
@section('icono')
    <i class="bi bi-folder-plus text-primary"></i>
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
    /* --- Diseño moderno clínico para Expedientes --- */
    .header-clinica {
        background: linear-gradient(135deg, #e8f2ff, #ffffff);
        border-bottom: 2px solid #d9e7ff;
        padding: 20px 25px;
        border-radius: 10px 10px 0 0;
    }

    .search-large {
        width: 380px !important;
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
</style>

<div class="card shadow-sm">

    <!-- Encabezado moderno -->
    <div class="header-clinica d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
        <h5 class="fw-bold text-primary">
            <i class="bi bi-list-ul"></i> Listado de Expedientes
        </h5>

        <div class="d-flex flex-column flex-md-row align-items-center gap-2">

            

            <!-- Buscador grande -->
            <form action="{{ route('expedientes.index') }}" method="GET" class="d-flex">
                <input type="text" 
                       name="search" 
                       class="form-control search-large me-2 shadow-sm" 
                       placeholder="Buscar por paciente..."
                       value="{{ request('search') }}">

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
                        <th>Fecha de Apertura</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($expedientes as $expediente)
                        <tr>
                            <td>{{ $expediente->Id_Expediente }}</td>
                            <td>{{ $expediente->paciente->Nombre ?? 'N/A' }} {{ $expediente->paciente->Apellido ?? '' }}</td>
                            <td>{{ \Carbon\Carbon::parse($expediente->Fecha_Apertura)->format('d/m/Y') }}</td>
                            <td>
                                <span class="badge 
                                    @if($expediente->Estado_Expediente == 'Activo') bg-success 
                                    @elseif($expediente->Estado_Expediente == 'Inactivo') bg-warning 
                                    @else bg-secondary @endif">
                                    {{ $expediente->Estado_Expediente }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('expedientes.edit', $expediente->Id_Expediente) }}" 
                                       class="btn btn-warning btn-sm" title="Editar expediente">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('expedientes.destroy', $expediente->Id_Expediente) }}" 
                                          method="POST" class="d-inline eliminar-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-eliminar" title="Eliminar expediente">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">
                                No hay expedientes registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $expedientes->links('pagination::bootstrap-5') }}
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
                title: '¿Eliminar este expediente?',
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
