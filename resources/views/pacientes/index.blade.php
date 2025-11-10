@extends('layouts.app')

@section('titulo', 'Pacientes')

@section('icono')
    <i class="bi bi-person-lines-fill text-primary"></i>
@endsection

@section('pacientes_active', 'active')

@section('contenido')
    {{-- Alerta de éxito --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    {{-- Alerta de error (por ejemplo, con withErrors) --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            @foreach ($errors->all() as $error)
                <div><i class="bi bi-exclamation-triangle-fill"></i> {{ $error }}</div>
            @endforeach
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Cerrar"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-header d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <span class="fw-semibold fs-5">
                <i class="bi bi-list-ul"></i> Listado de Pacientes
            </span>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('pacientes.create') }}" class="btn btn-new">
                    <i class="bi bi-person-plus"></i> Nuevo Paciente
                </a>
                <form action="{{ route('pacientes.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Buscar paciente..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-light">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle text-center">
                    <thead>
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
                                        <a href="{{ route('pacientes.show', $paciente->Id_Paciente) }}" class="btn btn-info btn-sm" title="Ver">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('pacientes.edit', $paciente->Id_Paciente) }}" class="btn btn-warning btn-sm" title="Editar">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('pacientes.destroy', $paciente->Id_Paciente) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm('¿Eliminar este paciente?')">
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
@endsection
