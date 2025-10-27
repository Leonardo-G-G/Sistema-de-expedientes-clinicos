<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pacientes - Panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary: #0d6efd; --bg: #f5f7fa; --sidebar-width: 250px; }
        body { background-color: var(--bg); font-family: 'Segoe UI', sans-serif; display: flex; margin: 0; min-height: 100vh; }
        .sidebar { width: var(--sidebar-width); background: linear-gradient(180deg, #0d6efd, #003c99); color: white; display: flex; flex-direction: column; position: fixed; height: 100%; box-shadow: 3px 0 15px rgba(0,0,0,0.15); z-index: 100; }
        .sidebar h2 { text-align: center; font-size: 1.4rem; font-weight: 600; padding: 1.2rem 0; border-bottom: 1px solid rgba(255,255,255,0.2); }
        .user-info { text-align: center; padding: 1rem; border-bottom: 1px solid rgba(255,255,255,0.2); }
        .user-info i { font-size: 3rem; color: #fff; }
        .user-info p { margin: 0.5rem 0 0; font-weight: 500; }
        .sidebar a { color: white; text-decoration: none; display: flex; align-items: center; gap: 10px; padding: 0.9rem 1.5rem; transition: background 0.3s; font-weight: 500; }
        .sidebar a:hover, .sidebar a.active { background-color: rgba(255,255,255,0.15); }
        .sidebar i { font-size: 1.3rem; }
        .logout-btn { margin: 1.2rem; background-color: #dc3545; border: none; color: white; padding: 0.6rem 1rem; border-radius: 8px; font-weight: 500; transition: background 0.3s; }
        .logout-btn:hover { background-color: #b52d3a; }
        .main-content { margin-left: var(--sidebar-width); padding: 2rem; flex: 1; }
        header h1 { font-size: 1.8rem; font-weight: 700; color: #333; margin-bottom: 2rem; }
        .card { border: none; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.08); }
        table thead { background-color: #0d6efd; color: white; }
        table tbody tr:hover { background-color: rgba(13,110,253,0.05); }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
         <h2>Sistema Clínico</h2>

        <div class="user-info">
            <i class="bi bi-person-circle"></i>
            <p>{{ Auth::user()->name ?? 'Usuario' }}</p>
        </div>

        <a href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a>
        <a href="{{ route('expedientes.create') }}"><i class="bi bi-folder-plus"></i> <span>Crear Expediente</span></a>
        <a href="{{ route('historia.create') }}"><i class="bi bi-file-earmark-medical"></i> <span>Historia Clínica</span></a>
        <a href="{{ route('pacientes.index') }}" class="active"><i class="bi bi-person-lines-fill"></i> <span>Pacientes</span></a>
        <a href="{{ route('notas.create') }}" class="{{ request()->routeIs('notas.create') ? 'active' : '' }}">
            <i class="bi bi-journal-medical"></i> <span>Nota Médica</span>
        </a>

       

        <form action="{{ route('logout') }}" method="POST" class="mt-auto text-center">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
            </button>
        </form>
    </aside>

    <!-- Main content -->
    <div class="main-content">
        <header>
            <h1>Lista de Pacientes</h1>
        </header>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <!-- 🔍 Buscador y botón -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <!-- Botón para crear paciente -->
            <a href="{{ route('pacientes.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus"></i> Nuevo Paciente
            </a>

            <!-- Buscador -->
            <form action="{{ route('pacientes.index') }}" method="GET" class="d-flex" style="max-width: 300px;">
                <input type="text" name="search" class="form-control me-2" placeholder="Buscar paciente..."
                    value="{{ request('search') }}">
                <button class="btn btn-outline-primary" type="submit">
                    <i class="bi bi-search"></i>
                </button>
            </form>
        </div>

        <!-- Tabla -->
        <div class="card p-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellido</th>
                            <th>Sexo</th>
                            <th>Teléfono</th>
                            <th>Lugar de origen</th>
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
                                <td>{{ $paciente->Telefono ?? '—' }}</td>
                                <td>{{ $paciente->Lugar_Origen ?? '—' }}</td>
                                <td>
                                    <a href="{{ route('pacientes.edit', $paciente->Id_Paciente) }}" class="btn btn-sm btn-warning">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <form action="{{ route('pacientes.destroy', $paciente->Id_Paciente) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar este paciente?')">
                                            <i class="bi bi-trash3"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-muted py-3">No hay pacientes registrados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- 🔄 Paginación -->
            <div class="d-flex justify-content-center mt-3">
                {{ $pacientes->appends(['search' => request('search')])->links() }}
            </div>
        </div>
    </div>

</body>
</html>
