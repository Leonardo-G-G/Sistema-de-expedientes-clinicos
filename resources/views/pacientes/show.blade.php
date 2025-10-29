<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paciente - {{ $paciente->Nombre }} {{ $paciente->Apellido }}</title>
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
        header { margin-bottom: 2rem; }
        header h1 { font-size: 1.8rem; font-weight: 700; color: #333; }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.05); transition: transform 0.25s ease, box-shadow 0.25s ease; }
        .card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.08); }
        .card-body { padding: 2rem; }
        footer { margin-top: 3rem; text-align: center; color: #666; font-size: 0.9rem; }
        @media (max-width: 768px) {
            .sidebar { position: relative; width: 100%; flex-direction: row; justify-content: space-around; height: auto; box-shadow: none; }
            .main-content { margin-left: 0; padding: 1rem; }
            .sidebar h2, .user-info { display: none; }
            .sidebar a span { display: none; }
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
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a>
        <a href="{{ route('expedientes.index') }}" class="{{ request()->routeIs('expedientes.*') ? 'active' : '' }}"><i class="bi bi-folder-plus"></i> <span>Expedientes</span></a>
        <a href="{{ route('historia.index') }}" class="{{ request()->routeIs('historia.*') ? 'active' : '' }}"><i class="bi bi-file-earmark-medical"></i> <span>Historia Clínica</span></a>
        <a href="{{ route('notas.index') }}" class="{{ request()->routeIs('notas.*') ? 'active' : '' }}"><i class="bi bi-journal-medical"></i> <span>Notas Médicas</span></a>
        <a href="{{ route('pacientes.index') }}" class="{{ request()->routeIs('pacientes.*') ? 'active' : '' }}"><i class="bi bi-person-lines-fill"></i> <span>Pacientes</span></a>
        <a href="{{ route('usuario.perfil') }}" class="{{ request()->routeIs('usuario.*') ? 'active' : '' }}"><i class="bi bi-person-circle"></i> <span>Perfil</span></a>
        <form action="{{ route('logout') }}" method="POST" class="mt-auto text-center">
            @csrf
            <button type="submit" class="logout-btn"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</button>
        </form>
    </aside>

    <!-- Contenido principal -->
    <div class="main-content">
        <header>
            <h1>Paciente: {{ $paciente->Nombre }} {{ $paciente->Apellido }}</h1>
        </header>

        <div class="card mb-3">
            <div class="card-header">
                <i class="bi bi-person-lines-fill"></i> Información Personal
            </div>
            <div class="card-body">
                <p><strong>Nombre completo:</strong> {{ $paciente->Nombre }} {{ $paciente->Apellido }}</p>
                <p><strong>Sexo:</strong> {{ $paciente->Sexo ?? '—' }}</p>
                <p><strong>Edad:</strong> {{ $paciente->edad ?? '—' }} años</p>
                <p><strong>Teléfono:</strong> {{ $paciente->Telefono ?? '—' }}</p>
                <p><strong>Contacto de Emergencia:</strong> {{ $paciente->Contacto_Emergencia ?? '—' }}</p>
                <p><strong>Lugar de Origen:</strong> {{ $paciente->Lugar_Origen ?? '—' }}</p>
                <p><strong>Expediente:</strong> {{ $paciente->expediente->Id_Expediente ?? 'No registrado' }}</p>
            </div>
        </div>

        <a href="{{ route('pacientes.index') }}" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Volver a la lista de pacientes
        </a>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
