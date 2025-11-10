@extends('layouts.app')

@section('titulo', 'Notas Médicas')
@section('icono')
    <i class="bi bi-journal-medical text-primary"></i>
@endsection

@section('contenido')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="card">
    <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
        <span class="fw-semibold fs-5">
            <i class="bi bi-list-ul"></i> Listado de Notas Médicas
        </span>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('notas.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nueva Nota
            </a>

            <form action="{{ route('notas.index') }}" method="GET" class="d-flex">
                <input type="text" name="search" class="form-control me-2" placeholder="Buscar paciente..." value="{{ request('search') }}">
                <input type="date" name="fecha" class="form-control me-2" value="{{ request('fecha') }}">
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
                                    <a href="{{ route('notas.show', $nota->Id_Nota) }}" class="btn btn-info btn-sm" data-bs-toggle="tooltip" title="Ver detalles">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('notas.edit', $nota->Id_Nota) }}" class="btn btn-warning btn-sm" data-bs-toggle="tooltip" title="Editar nota">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('notas.destroy', $nota->Id_Nota) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" data-bs-toggle="tooltip" title="Eliminar nota" onclick="return confirm('¿Desea eliminar esta nota médica?')">
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

@endsection
