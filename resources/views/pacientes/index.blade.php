@extends('layouts.app')

@section('titulo', 'Pacientes')

@section('icono')
    <i class="bi bi-person-lines-fill text-primary"></i>
@endsection

@section('pacientes_active', 'active')

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
            <i class="bi bi-list-ul"></i> Listado de Pacientes
        </h5>

        <div class="d-flex flex-column flex-md-row align-items-center gap-2">

            <a href="{{ route('pacientes.create') }}" class="btn btn-primary px-4">
                <i class="bi bi-person-plus"></i> Nuevo Paciente
            </a>

            <!-- Buscador grande -->
            <form action="{{ route('pacientes.index') }}" method="GET" class="d-flex">
                <input type="text" 
                       name="search" 
                       class="form-control search-large me-2 shadow-sm" 
                       placeholder="Buscar paciente por nombre..." 
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
                        <th>Nombre</th>
                        <th>Apellido</th>
                        <th>Sexo</th>
                        <th>Edad</th>
                        <th>Teléfono</th>
                        <th>Contacto de Emergencia</th>
                        <th>Lugar de Origen</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pacientes as $paciente)
                        <tr>
                            <td>{{ $paciente->Id_Paciente }}</td>
                            <td>{{ $paciente->Nombre }}</td>
                            <td>{{ $paciente->Apellido }}</td>
                            <td>{{ $paciente->Sexo ?? '—' }}</td>
                            <td>{{ $paciente->edad ?? '—' }}</td>
                            <td>{{ $paciente->Telefono ?? '—' }}</td>
                            <td>{{ $paciente->Contacto_Emergencia ?? '—' }}</td>
                            <td>{{ $paciente->Lugar_Origen ?? '—' }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('pacientes.show', $paciente->Id_Paciente) }}" 
                                       class="btn btn-info btn-sm">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    <a href="{{ route('pacientes.edit', $paciente->Id_Paciente) }}" 
                                       class="btn btn-warning btn-sm">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('pacientes.destroy', $paciente->Id_Paciente) }}" 
                                          method="POST" class="d-inline eliminar-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-eliminar">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No hay pacientes registrados</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $pacientes->appends(['search' => request('search')])->links('pagination::bootstrap-5') }}
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
                title: '¿Eliminar este paciente?',
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
