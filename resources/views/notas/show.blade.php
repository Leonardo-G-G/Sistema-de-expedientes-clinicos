<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Médica - Sistema Clínico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #0077b6;
            --primary-dark: #023e8a;
            --bg: #edf2f7;
            --card-bg: #ffffff;
            --text-dark: #333;
            --shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        body {
            background: var(--bg);
            font-family: "Poppins", sans-serif;
            display: flex;
            margin: 0;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: linear-gradient(180deg, var(--primary-dark), var(--primary));
            color: #fff;
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100%;
            box-shadow: 3px 0 10px rgba(0,0,0,0.15);
        }

        .sidebar h2 {
            text-align: center;
            padding: 1.4rem 0;
            font-size: 1.6rem;
            letter-spacing: 0.5px;
            border-bottom: 1px solid rgba(255,255,255,0.15);
        }

        .user-info {
            text-align: center;
            padding: 1rem;
            border-bottom: 1px solid rgba(255,255,255,0.15);
        }

        .user-info i {
            font-size: 3rem;
            color: #fff;
        }

        .user-info p {
            font-weight: 500;
            margin-top: 0.5rem;
        }

        .sidebar a {
            color: #e0e0e0;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0.9rem 1.4rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: rgba(255,255,255,0.15);
            border-left: 4px solid #fff;
            color: #fff;
            padding-left: 1.1rem;
        }

        .logout-btn {
            margin: 1.4rem;
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-weight: 500;
            transition: 0.3s;
        }

        .logout-btn:hover {
            background-color: #b52d3a;
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 260px;
            padding: 2rem;
            flex: 1;
        }

        header {
            background: linear-gradient(90deg, var(--primary-dark), var(--primary));
            color: white;
            padding: 1.2rem 1.8rem;
            border-radius: 16px;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }

        header h1 {
            font-size: 1.8rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        header h1 i {
            font-size: 1.9rem;
        }

        /* CARD DESIGN */
        .card {
            border: none;
            border-radius: 16px;
            background: var(--card-bg);
            box-shadow: var(--shadow);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 12px 25px rgba(0,0,0,0.1);
        }

        .card-header {
            background-color: transparent;
            border-bottom: 1px solid #e9ecef;
            font-weight: 600;
            font-size: 1.1rem;
            color: var(--primary-dark);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .card-body p {
            color: var(--text-dark);
            margin-bottom: 0.6rem;
        }

        .info-group strong {
            color: var(--primary-dark);
        }

        hr {
            opacity: 0.15;
        }

        /* BUTTONS */
        .btn {
            border-radius: 10px;
            font-weight: 500;
            padding: 0.6rem 1.3rem;
        }

        .btn i {
            margin-right: 6px;
        }

        .btn-primary {
            background-color: var(--primary);
            border-color: var(--primary);
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            border-color: var(--primary-dark);
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {
            .sidebar {
                position: relative;
                width: 100%;
                height: auto;
                flex-direction: row;
                overflow-x: auto;
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            header {
                border-radius: 10px;
                text-align: center;
            }
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

    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> Dashboard
    </a>
    <a href="{{ route('expedientes.index') }}" class="{{ request()->routeIs('expedientes.*') ? 'active' : '' }}">
        <i class="bi bi-folder-plus"></i> Expedientes
    </a>
    <a href="{{ route('historia.index') }}" class="{{ request()->routeIs('historia.*') ? 'active' : '' }}">
        <i class="bi bi-file-earmark-medical"></i> Historias Clínicas
    </a>
    <a href="{{ route('notas.index') }}" class="active">
        <i class="bi bi-journal-medical"></i> Notas Médicas
    </a>
    <a href="{{ route('usuario.perfil') }}" class="{{ request()->routeIs('usuario.*') ? 'active' : '' }}">
        <i class="bi bi-person-circle"></i> Perfil
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
        <h1><i class="bi bi-clipboard2-pulse"></i> Nota Médica</h1>
        <p class="mb-0">Paciente: <strong>{{ $nota->historiaClinica->expediente->paciente->Nombre ?? '---' }} {{ $nota->historiaClinica->expediente->paciente->Apellido ?? '' }}</strong></p>
    </header>

    <div class="card mb-4">
        <div class="card-header"><i class="bi bi-journal-text"></i> Información General</div>
        <div class="card-body">
            <p><strong>Fecha:</strong> {{ $nota->Fecha ?? '---' }} | <strong>Hora:</strong> {{ $nota->Hora ?? '---' }}</p>
            <hr>
            <div class="row">
                <div class="col-md-3"><p><strong>Peso:</strong> {{ $nota->Peso ?? '---' }} kg</p></div>
                <div class="col-md-3"><p><strong>Talla:</strong> {{ $nota->Talla ?? '---' }} m</p></div>
                <div class="col-md-3"><p><strong>Presión Arterial:</strong> {{ $nota->Presion_Arterial ?? '---' }}</p></div>
                <div class="col-md-3"><p><strong>Frecuencia Cardíaca:</strong> {{ $nota->Frecuencia_Cardiaca ?? '---' }}</p></div>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-header"><i class="bi bi-heart-pulse"></i> Evaluación Médica</div>
        <div class="card-body">
            <p><strong>Exploración Física:</strong></p>
            <p class="ms-3">{{ $nota->Exploracion_Fisica ?? '---' }}</p>

            <p><strong>Diagnóstico:</strong></p>
            <p class="ms-3">{{ $nota->Diagnostico ?? '---' }}</p>

            <p><strong>Tratamiento:</strong></p>
            <p class="ms-3">{{ $nota->Tratamiento ?? '---' }}</p>

            <p><strong>Plan a Seguir:</strong></p>
            <p class="ms-3">{{ $nota->Plan_A_Seguir ?? '---' }}</p>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('notas.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver
        </a>
        <a href="{{ route('notas.edit', $nota->Id_Nota) }}" class="btn btn-primary">
            <i class="bi bi-pencil-square"></i> Editar Nota
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
