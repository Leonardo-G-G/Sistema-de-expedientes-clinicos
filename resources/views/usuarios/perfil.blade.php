<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil del Usuario - Sistema Clínico</title>
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

        /* Main */
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            flex: 1;
        }

        header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            padding: 2rem;
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
        }

        .card p {
            font-size: 1rem;
            margin-bottom: 0.8rem;
        }

        .card strong {
            color: #333;
        }

        .btn-primary {
            border-radius: 10px;
            padding: 0.6rem 1.5rem;
            font-weight: 500;
        }

        footer {
            margin-top: 3rem;
            text-align: center;
            color: #666;
            font-size: 0.9rem;
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

        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
        </a>

        <a href="{{ route('expedientes.index') }}" class="{{ request()->routeIs('expedientes.create') ? 'active' : '' }}">
            <i class="bi bi-folder-plus"></i> <span>Expedientes</span>
        </a>

        <a href="{{ route('historia.index') }}" class="{{ request()->routeIs('historia.create') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-medical"></i> <span>Historia Clínica</span>
        </a>

        <a href="{{ route('pacientes.index') }}" class="{{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
            <i class="bi bi-person-lines-fill"></i> <span>Pacientes</span>
        </a>

        <a href="{{ route('notas.index') }}" class="{{ request()->routeIs('notas.create') ? 'active' : '' }}">
            <i class="bi bi-journal-medical"></i> <span>Nota Médica</span>
        </a>

        <a href="{{ route('usuario.perfil') }}" class="{{ request()->routeIs('usuario.*') ? 'active' : '' }}">
            <i class="bi bi-person-circle"></i> <span>Perfil</span>
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
            <h1>Perfil del Usuario</h1>
        </header>

        <div class="card">
            <p><strong>Nombre:</strong> {{ $usuario->Nombre }} {{ $usuario->Apellido }}</p>
            <p><strong>Correo electrónico:</strong> {{ $usuario->Correo_Electronico }}</p>
            <p><strong>Especialidad:</strong> {{ $usuario->Especialidad ?? 'No especificada' }}</p>

            <div class="text-center mt-4">
                <a href="{{ route('usuario.editar') }}" class="btn btn-primary">
                    <i class="bi bi-pencil-square"></i> Editar Perfil
                </a>
            </div>
        </div>

        <footer>
            <p>© {{ date('Y') }} Clínica Quirúrgica Téran — Sistema Clínico</p>
        </footer>
    </div>
</body>
</html>
