@extends('layouts.app')

@section('titulo', 'Expedientes')
@section('icono')
    <i class="bi bi-folder-plus text-primary"></i>
@endsection

@section('contenido')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
        <span class="fw-semibold fs-5">
            <i class="bi bi-list-ul"></i> Listado de Expedientes
        </span>

        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('expedientes.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuevo Expediente
            </a>

            <form action="{{ route('expedientes.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Buscar expediente..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i></button>
            </form>
        </div>
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle text-center">
                <thead>
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
                                       class="btn btn-warning btn-sm" data-bs-toggle="tooltip" 
                                       title="Editar expediente">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('expedientes.destroy', $expediente->Id_Expediente) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Eliminar expediente" onclick="return confirm('¿Eliminar este expediente?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-3">No hay expedientes registrados.</td>
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

@endsection
