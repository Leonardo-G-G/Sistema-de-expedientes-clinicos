<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historias Clínicas</title>
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

        /* === Sidebar === */
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
            font-size: 1.4rem;
            font-weight: 600;
            padding: 1.2rem 0;
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

        .sidebar a:hover,
        .sidebar a.active {
            background-color: rgba(255,255,255,0.15);
        }

        .sidebar i {
            font-size: 1.3rem;
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

        /* === Main content === */
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

        footer {
            margin-top: 3rem;
            text-align: center;
            color: #666;
            font-size: 0.9rem;
        }

        /* Responsive */
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

            .sidebar h2,
            .user-info {
                display: none;
            }

            .sidebar a span {
                display: none;
            }
        }
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

        <!-- 🔗 Menú de navegación -->
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
        </a>

        <a href="{{ route('expedientes.index') }}">
            <i class="bi bi-folder-plus"></i> <span>Expedientes</span>
        </a>

        <a href="{{ route('historia.index') }}" class="active">
            <i class="bi bi-file-earmark-medical"></i> <span>Historia Clínica</span>
        </a>

        <a href="{{ route('pacientes.index') }}">
            <i class="bi bi-person-lines-fill"></i> <span>Pacientes</span>
        </a>

        <a href="{{ route('notas.index') }}">
            <i class="bi bi-journal-medical"></i> <span>Nota Médica</span>
        </a>

        <a href="{{ route('usuario.perfil') }}">
            <i class="bi bi-person-circle"></i> <span>Perfil</span>
        </a>

        <form action="{{ route('logout') }}" method="POST" class="mt-auto text-center">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
            </button>
        </form>
    </aside>

    <div class="main-content">
        <header>
            <h1>Historias Clínicas</h1>
        </header>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <span>Listado de Historias Clínicas</span>
                
                <div class="d-flex align-items-center gap-2">
                    <!-- 🔵 Nuevo botón -->
                    <a href="{{ route('historia.create') }}" class="btn btn-new">
                        <i class="bi bi-plus-circle"></i> Crear nuevo historial
                    </a>

                    <!-- 🔍 Barra de búsqueda -->
                    <form action="{{ route('historia.index') }}" method="GET" class="d-flex">
                        <input type="text" name="search" class="form-control me-2" placeholder="Buscar por paciente..." value="{{ request('search') }}">
                        <button type="submit" class="btn btn-light"><i class="bi bi-search"></i></button>
                    </form>
                </div>
            </div>

            <div class="card-body">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Paciente</th>
                            <th>Padecimiento Actual</th>
                            <th>Exploración Física</th>
                            <th>Estado Expediente</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($historias as $historia)
                            <tr>
                                <td>{{ $historia->Id_Historia }}</td>
                                <td>{{ $historia->expediente->paciente->Nombre }} {{ $historia->expediente->paciente->Apellido }}</td>
                                <td>{{ Str::limit($historia->Padecimiento_Actual, 50) }}</td>
                                <td>{{ Str::limit($historia->Exploracion_Fisica, 50) }}</td>
                                <td>{{ $historia->expediente->Estado_Expediente }}</td>
                                <td>
                                    <a href="{{ route('historia.show', $historia->Id_Historia) }}" class="btn btn-info btn-sm"><i class="bi bi-eye"></i></a>
                                    <a href="{{ route('historia.edit', $historia->Id_Historia) }}" class="btn btn-warning btn-sm"><i class="bi bi-pencil"></i></a>
                                    <form action="{{ route('historia.destroy', $historia->Id_Historia) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Desea eliminar esta historia clínica?')"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No se encontraron registros</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="d-flex justify-content-center">
                    {{ $historias->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

</body>
</html>
