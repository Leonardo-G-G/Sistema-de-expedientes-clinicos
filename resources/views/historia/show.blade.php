<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Historia Clínica - Detalles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary: #0d6efd; --bg: #f5f7fa; --sidebar-width: 250px; }
        body { background-color: var(--bg); font-family: 'Segoe UI', sans-serif; display: flex; margin: 0; min-height: 100vh; }
        .sidebar { width: var(--sidebar-width); background: linear-gradient(180deg, #0d6efd, #003c99); color: white; display: flex; flex-direction: column; position: fixed; height: 100%; }
        .sidebar h2 { text-align: center; padding: 1rem 0; border-bottom: 1px solid rgba(255,255,255,0.2); }
        .user-info { text-align: center; padding: 1rem; border-bottom: 1px solid rgba(255,255,255,0.2); }
        .sidebar a { color: white; text-decoration: none; display: flex; align-items: center; gap: 10px; padding: 0.8rem 1.5rem; font-weight: 500; }
        .sidebar a.active, .sidebar a:hover { background-color: rgba(255,255,255,0.15); }
        .logout-btn { margin: 1rem; }
        .main-content { margin-left: var(--sidebar-width); padding: 2rem; flex: 1; }
        .card { border-radius: 12px; margin-bottom: 1.5rem; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        .card-header { background-color: var(--primary); color: white; font-weight: 600; }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <h2>Sistema Clínico</h2>
        <div class="user-info">
            <i class="bi bi-person-circle fs-2"></i>
            <p>{{ Auth::user()->name ?? 'Usuario' }}</p>
        </div>
        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-speedometer2"></i> Dashboard
        </a>
        <a href="{{ route('expedientes.index') }}" class="{{ request()->routeIs('expedientes.*') ? 'active' : '' }}">
            <i class="bi bi-folder2-open"></i> Expedientes
        </a>
        <a href="{{ route('historia.index') }}" class="active">
            <i class="bi bi-file-earmark-medical"></i> Historia Clínica
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
            <button type="submit" class="btn btn-danger mt-3">
                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
            </button>
        </form>
    </aside>

    <!-- Contenido principal -->
    <div class="main-content">
        <header>
            <h1>Historia Clínica de {{ $historia->expediente->paciente->Nombre ?? '---' }} {{ $historia->expediente->paciente->Apellido ?? '' }}</h1>
        </header>

        <!-- Datos Generales -->
        <div class="card">
            <div class="card-header">Datos Generales</div>
            <div class="card-body">
                <p><strong>Expediente ID:</strong> {{ $historia->Expediente_Id }}</p>
<p><strong>Fecha de Creación:</strong> {{ now()->format('d/m/Y') }}</p>

            </div>
        </div>

        <!-- Antecedentes Heredofamiliares -->
        <div class="card">
            <div class="card-header">Antecedentes Heredofamiliares</div>
            <div class="card-body">
                <p><strong>Diabetes:</strong> {{ $historia->heredofamiliares->Diabetes ? 'Sí' : 'No' }}</p>
                <p><strong>Hipertensión:</strong> {{ $historia->heredofamiliares->Hipertension ? 'Sí' : 'No' }}</p>
                <p><strong>Cáncer:</strong> {{ $historia->heredofamiliares->Cancer ? 'Sí' : 'No' }}</p>
                <p><strong>Enfermedades Crónicas:</strong> {{ $historia->heredofamiliares->Enfermedades_Cronicas ?? '---' }}</p>
                <p><strong>Otros:</strong> {{ $historia->heredofamiliares->Otros ?? '---' }}</p>
            </div>
        </div>

        <!-- Antecedentes No Patológicos -->
        <div class="card">
            <div class="card-header">Antecedentes No Patológicos</div>
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
        <div class="card">
            <div class="card-header">Antecedentes Patológicos</div>
            <div class="card-body">
                <p><strong>Descripción:</strong> {{ $historia->patologicos->Descripcion ?? '---' }}</p>
            </div>
        </div>

        <!-- Antecedentes Ginecoobstétricos -->
        <div class="card">
            <div class="card-header">Antecedentes Ginecoobstétricos</div>
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
        <div class="card">
            <div class="card-header">Nota Médica</div>
            <div class="card-body">
                @foreach($historia->notaMedicas->sortByDesc('Fecha') as $nota)
                <div class="border-bottom mb-3 pb-2">
                    <p><strong>Fecha:</strong> {{ $nota->Fecha ?? '---' }} |
                       <strong>Hora:</strong> {{ $nota->Hora ?? '---' }}</p>
                    <p><strong>Peso:</strong> {{ $nota->Peso ?? '---' }} kg |
                       <strong>Talla:</strong> {{ $nota->Talla ?? '---' }} cm</p>
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

        <a href="{{ route('historia.index') }}" class="btn btn-secondary mt-3">
            <i class="bi bi-arrow-left"></i> Volver al listado
        </a>
    </div>
</body>
</html>
