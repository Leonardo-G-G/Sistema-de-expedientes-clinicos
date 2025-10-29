<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pacientes - Sistema Clínico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #0d6efd;
            --bg: #f5f7fa;
            --sidebar-width: 250px;
        }

        body {
            background-color: var(--bg);
            font-family: 'Segoe UI', sans-serif;
            display: flex;
            margin: 0;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: var(--sidebar-width);
            background: linear-gradient(180deg, #0d6efd, #003c99);
            color: white;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
            box-shadow: 3px 0 15px rgba(0,0,0,0.15);
            z-index: 100;
        }

        .sidebar h2 {
            text-align: center;
            padding: 1.2rem 0;
            font-size: 1.4rem;
            font-weight: 600;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .user-info {
            text-align: center;
            padding: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }

        .user-info i {
            font-size: 3rem;
            color: #fff;
        }

        .user-info p {
            margin: 0.5rem 0 0;
            font-weight: 500;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.9rem 1.5rem;
            transition: background 0.3s;
            font-weight: 500;
        }

        .sidebar a:hover, .sidebar a.active {
            background-color: rgba(255,255,255,0.15);
        }

        .logout-btn {
            margin: 1.2rem;
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            transition: background 0.3s;
        }

        .logout-btn:hover {
            background-color: #b52d3a;
        }

        /* Main content */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            flex: 1;
        }

        header {
            margin-bottom: 2rem;
        }

        header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
        }

        .card-body {
            padding: 2rem;
        }

        .btn-new {
            background-color: var(--primary);
            color: white;
            font-weight: 500;
            border-radius: 10px;
            padding: 0.6rem 1rem;
            transition: background 0.3s;
        }

        .btn-new:hover {
            background-color: #084298;
            color: white;
        }

        table tbody tr:hover {
            background-color: rgba(13,110,253,0.05);
        }

        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                flex-direction: row;
                justify-content: space-around;
                height: auto;
                box-shadow: none;
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .sidebar h2, .user-info { display: none; }
            .sidebar a span { display: none; }
        }
    </style>
</head>

<body>
<aside class="sidebar">
    <h2>Sistema Clínico</h2>
    <div class="user-info">
        <i class="bi bi-person-circle"></i>
        <p>{{ Auth::user()->name ?? 'Usuario' }}</p>
    </div>

    <a href="{{ route('dashboard') }}"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a>
    <a href="{{ route('expedientes.index') }}"><i class="bi bi-folder-plus"></i> <span>Expedientes</span></a>
    <a href="{{ route('historia.index') }}"><i class="bi bi-file-earmark-medical"></i> <span>Historia Clínica</span></a>
    <a href="{{ route('pacientes.index') }}" class="active"><i class="bi bi-person-lines-fill"></i> <span>Pacientes</span></a>
    <a href="{{ route('notas.index') }}"><i class="bi bi-journal-medical"></i> <span>Nota Médica</span></a>
    <a href="{{ route('usuario.perfil') }}"><i class="bi bi-person-circle"></i> <span>Perfil</span></a>

    <form action="{{ route('logout') }}" method="POST" class="mt-auto text-center">
        @csrf
        <button type="submit" class="logout-btn"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</button>
    </form>
</aside>

<div class="main-content">
    <header>
        <h1>Pacientes</h1>
    </header>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Listado de Pacientes</span>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('pacientes.create') }}" class="btn btn-new"><i class="bi bi-person-plus"></i> Nuevo Paciente</a>
                <form action="{{ route('pacientes.index') }}" method="GET" class="d-flex">
                    <input type="text" name="search" class="form-control me-2" placeholder="Buscar paciente..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-light"><i class="bi bi-search"></i></button>
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
                                    <a href="{{ route('pacientes.show', $paciente->Id_Paciente) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('pacientes.edit', $paciente->Id_Paciente) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil-square"></i></a>
                                    <form action="{{ route('pacientes.destroy', $paciente->Id_Paciente) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Eliminar este paciente?')"><i class="bi bi-trash3"></i></button>
                                    </form>
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
