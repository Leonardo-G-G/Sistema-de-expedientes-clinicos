@extends('layouts.app')

@section('titulo', 'Historias Clínicas')
@section('icono')
    <i class="bi bi-file-earmark-medical text-primary"></i>
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

<!-- ⚠️ Mensajes de error -->
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

<div class="card shadow-sm">
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2 bg-light">
        <span class="fw-semibold fs-5"><i class="bi bi-list-ul text-primary"></i> Listado de Historias Clínicas</span>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('historia.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Crear Historia
            </a>

            <form action="{{ route('historia.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Buscar por paciente..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle text-center">
                <thead class="table-primary">
                    <tr>
                        <th>ID</th>
                        <th>Paciente</th>
                        <th>Estado Expediente</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($historias as $historia)
                        <tr>
                            <td>{{ $historia->Id_Historia }}</td>
                            <td>{{ $historia->expediente->paciente->Nombre }} {{ $historia->expediente->paciente->Apellido }}</td>
                            <td>{{ $historia->expediente->Estado_Expediente }}</td>
                            <td>
                                <div class="d-flex justify-content-center gap-2">
                                    <a href="{{ route('historia.show', $historia->Id_Historia) }}" 
                                       class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('historia.edit', $historia->Id_Historia) }}" 
                                       class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Editar historia">
                                        <i class="bi bi-pencil"></i>
                                    </a>

                                    <form action="{{ route('historia.destroy', $historia->Id_Historia) }}" 
                                          method="POST" class="d-inline eliminar-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-eliminar" title="Eliminar historia">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">No se encontraron registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $historias->links('pagination::bootstrap-5') }}
        </div>
    </div>
</div>

<!-- SweetAlert2 Confirmación al eliminar -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.btn-eliminar').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            let form = this.closest('.eliminar-form');

            Swal.fire({
                title: '¿Eliminar esta historia clínica?',
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
