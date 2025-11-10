<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia Clínica - Sistema Clínico</title>
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
    <a href="{{ route('historia.index') }}" class="active">
        <i class="bi bi-file-earmark-medical"></i> Historias Clínicas
    </a>
    <a href="{{ route('pacientes.index') }}" class="{{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
        <i class="bi bi-people"></i> Pacientes
    </a>
    <a href="{{ route('notas.index') }}" class="{{ request()->routeIs('notas.*') ? 'active' : '' }}">
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
        <h1><i class="bi bi-clipboard2-pulse"></i> Historia Clínica</h1>
        <p class="mb-0">Paciente: <strong>{{ $historia->expediente->paciente->Nombre ?? '---' }} {{ $historia->expediente->paciente->Apellido ?? '' }}</strong></p>
    </header>

    <!-- Datos Generales -->
    <div class="card mb-4">
        <div class="card-header"><i class="bi bi-info-circle"></i> Datos Generales</div>
        <div class="card-body">
            <p><strong>ID Expediente:</strong> {{ $historia->Expediente_Id }}</p>
            <p><strong>Fecha de Creación:</strong> {{ now()->format('d/m/Y') }}</p>
        </div>
    </div>

    <!-- Antecedentes Heredofamiliares -->
    <div class="card mb-4">
        <div class="card-header"><i class="bi bi-people"></i> Antecedentes Heredofamiliares</div>
        <div class="card-body">
            <p><strong>Diabetes:</strong> {{ $historia->heredofamiliares->Diabetes ? 'Sí' : 'No' }}</p>
            <p><strong>Hipertensión:</strong> {{ $historia->heredofamiliares->Hipertension ? 'Sí' : 'No' }}</p>
            <p><strong>Cáncer:</strong> {{ $historia->heredofamiliares->Cancer ? 'Sí' : 'No' }}</p>
            <p><strong>Enfermedades Crónicas:</strong> {{ $historia->heredofamiliares->Enfermedades_Cronicas ?? '---' }}</p>
            <p><strong>Otros:</strong> {{ $historia->heredofamiliares->Otros ?? '---' }}</p>
        </div>
    </div>

    <!-- Antecedentes No Patológicos -->
    <div class="card mb-4">
        <div class="card-header"><i class="bi bi-house-heart"></i> Antecedentes No Patológicos</div>
        <div class="card-body">
            <p><strong>Tipo de Vivienda:</strong> {{ $historia->noPatologicos->Tipo_Vivienda ?? '---' }}</p>
            <p><strong>Religión:</strong> {{ $historia->noPatologicos->Religion ?? '---' }}</p>
            <p><strong>Alimentación:</strong> {{ $historia->noPatologicos->Alimentacion ?? '---' }}</p>
            <p><strong>Actividad Física:</strong> {{ $historia->noPatologicos->Actividad_Fisica ?? '---' }}</p>
            <p><strong>Tabaquismo:</strong> {{ $historia->noPatologicos->Tabaquismo ? 'Sí' : 'No' }}</p>
            <p><strong>Alcoholismo:</strong> {{ $historia->noPatologicos->Alcoholismo ? 'Sí' : 'No' }}</p>
            <p><strong>Drogas:</strong> {{ $historia->noPatologicos->Drogas ? 'Sí' : 'No' }}</p>
        </div>
    </div>

    <!-- Antecedentes Patológicos -->
    <div class="card mb-4">
        <div class="card-header"><i class="bi bi-clipboard2-heart"></i> Antecedentes Patológicos</div>
        <div class="card-body">
            <p><strong>Descripción:</strong> {{ $historia->patologicos->Descripcion ?? '---' }}</p>
        </div>
    </div>

    <!-- Antecedentes Ginecoobstétricos -->
    <div class="card mb-4">
        <div class="card-header"><i class="bi bi-gender-female"></i> Antecedentes Ginecoobstétricos</div>
        <div class="card-body">
            <p><strong>Menarca (Edad):</strong> {{ $historia->ginecoobstetricos->Menarca_Edad ?? '---' }}</p>
            <p><strong>Tipo de Ciclo:</strong> {{ $historia->ginecoobstetricos->Tipo_Ciclo ?? '---' }}</p>
            <p><strong>Ciclos Dolorosos:</strong> {{ $historia->ginecoobstetricos->Ciclos_Dolor ? 'Sí' : 'No' }}</p>
            <p><strong>Última Regla:</strong> {{ $historia->ginecoobstetricos->Ultima_Regla ?? '---' }}</p>
            <p><strong>Inicio Vida Sexual:</strong> {{ $historia->ginecoobstetricos->Inicio_Vida_Sexual ?? '---' }}</p>
            <p><strong>Gestaciones:</strong> {{ $historia->ginecoobstetricos->Gestaciones ?? '0' }}</p>
            <p><strong>Partos:</strong> {{ $historia->ginecoobstetricos->Partos ?? '0' }}</p>
            <p><strong>Abortos:</strong> {{ $historia->ginecoobstetricos->Abortos ?? '0' }}</p>
            <p><strong>Cesáreas:</strong> {{ $historia->ginecoobstetricos->Cesareas ?? '0' }}</p>
        </div>
    </div>

    <!-- Nota Médica -->
    @if($historia->notaMedicas && $historia->notaMedicas->count() > 0)
    <div class="card mb-4">
        <div class="card-header"><i class="bi bi-journal-text"></i> Notas Médicas</div>
        <div class="card-body">
            @foreach($historia->notaMedicas->sortByDesc('Fecha') as $nota)
            <div class="border-bottom mb-3 pb-2">
                <p><strong>Fecha:</strong> {{ $nota->Fecha ?? '---' }} |
                   <strong>Hora:</strong> {{ $nota->Hora ?? '---' }}</p>
                <p><strong>Peso:</strong> {{ $nota->Peso ?? '---' }} kg |
                   <strong>Talla:</strong> {{ $nota->Talla ?? '---' }} m</p>
                <p><strong>Presión Arterial:</strong> {{ $nota->Presion_Arterial ?? '---' }}</p>
                <p><strong>Frecuencia Cardíaca:</strong> {{ $nota->Frecuencia_Cardiaca ?? '---' }}</p>
                <p><strong>Exploración Física:</strong> {{ $nota->Exploracion_Fisica ?? '---' }}</p>
                <p><strong>Diagnóstico:</strong> {{ $nota->Diagnostico ?? '---' }}</p>
                <p><strong>Tratamiento:</strong> {{ $nota->Tratamiento ?? '---' }}</p>
                <p><strong>Plan a Seguir:</strong> {{ $nota->Plan_A_Seguir ?? '---' }}</p>
            </div>
            @endforeach
        </div>
    </div>
    @else
    <div class="alert alert-info">No hay notas médicas registradas para esta historia clínica.</div>
    @endif

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('historia.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver al listado
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
