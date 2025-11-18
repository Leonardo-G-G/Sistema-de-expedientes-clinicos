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

        .card {
            border: none;
            border-radius: 16px;
            background: var(--card-bg);
            box-shadow: var(--shadow);
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
        <p class="mb-0">Paciente: 
            <strong>{{ $historia->expediente->paciente->Nombre ?? '---' }} {{ $historia->expediente->paciente->Apellido ?? '' }}</strong>
        </p>
    </header>



    <!-- Datos Generales -->
    <div class="card mb-4">
        <div class="card-header"><i class="bi bi-info-circle"></i> Datos Generales</div>
        <div class="card-body">
            <p><strong>ID Expediente:</strong> {{ $historia->Expediente_Id }}</p>
            <p><strong>Fecha de Creación:</strong> {{ $historia->created_at ? $historia->created_at->format('d/m/Y') : now()->format('d/m/Y') }}</p>
        </div>
    </div>

    <!-- Antecedentes Heredofamiliares -->
    <div class="card mb-4">
        <div class="card-header"><i class="bi bi-people"></i> Antecedentes Heredofamiliares</div>
        <div class="card-body">
            <p><strong>Diabetes:</strong> {{ optional($historia->heredofamiliares)->Diabetes ? 'Sí' : 'No' }}</p>
            <p><strong>Hipertensión:</strong> {{ optional($historia->heredofamiliares)->Hipertension ? 'Sí' : 'No' }}</p>
            <p><strong>Cáncer:</strong> {{ optional($historia->heredofamiliares)->Cancer ? 'Sí' : 'No' }}</p>
            <p><strong>Descripción:</strong> {{ optional($historia->heredofamiliares)->Descripcion ?? '---' }}</p>
        </div>
    </div>

    <!-- Antecedentes No Patológicos -->
    <div class="card mb-4">
        <div class="card-header"><i class="bi bi-house-heart"></i> Antecedentes No Patológicos</div>
        <div class="card-body">
            <p><strong>Tipo de Vivienda:</strong> {{ optional($historia->noPatologicos)->Tipo_Vivienda ?? '---' }}</p>
            <p><strong>Religión:</strong> {{ optional($historia->noPatologicos)->Religion ?? '---' }}</p>
            <p><strong>Alimentación:</strong> {{ optional($historia->noPatologicos)->Alimentacion ?? '---' }}</p>
            <p><strong>Actividad Física:</strong> {{ optional($historia->noPatologicos)->Actividad_Fisica ?? '---' }}</p>
            <p><strong>Tipo de Sangre:</strong> {{ optional($historia->noPatologicos)->Tipo_Sangre ?? '---' }}</p>
            <p><strong>Tabaquismo:</strong> {{ optional($historia->noPatologicos)->Tabaquismo ? 'Sí' : 'No' }}</p>
            <p><strong>Alcoholismo:</strong> {{ optional($historia->noPatologicos)->Alcoholismo ? 'Sí' : 'No' }}</p>
            <p><strong>Drogas:</strong> {{ optional($historia->noPatologicos)->Drogas ? 'Sí' : 'No' }}</p>
        </div>
    </div>

    <!-- Antecedentes Patológicos -->
    <div class="card mb-4">
        <div class="card-header"><i class="bi bi-clipboard2-heart"></i> Antecedentes Patológicos</div>
        <div class="card-body">
            <p><strong>Descripción:</strong> {{ optional($historia->patologicos)->Descripcion ?? '---' }}</p>
        </div>
    </div>

    <!-- Antecedentes Ginecoobstétricos -->
    <div class="card mb-4">
        <div class="card-header"><i class="bi bi-gender-female"></i> Antecedentes Ginecoobstétricos</div>
        <div class="card-body">
            <p><strong>Menarca (Edad):</strong> {{ optional($historia->ginecoobstetricos)->Menarca_Edad ?? '---' }}</p>
            <p><strong>Tipo de Ciclo:</strong> {{ optional($historia->ginecoobstetricos)->Tipo_Ciclo ?? '---' }}</p>
            <p><strong>Ciclos Dolorosos:</strong> {{ optional($historia->ginecoobstetricos)->Ciclos_Dolor ? 'Sí' : 'No' }}</p>
            <p><strong>Última Regla:</strong> {{ optional($historia->ginecoobstetricos)->Ultima_Regla ?? '---' }}</p>
            <p><strong>Inicio Vida Sexual:</strong> {{ optional($historia->ginecoobstetricos)->Inicio_Vida_Sexual ?? '---' }}</p>
            <p><strong>Gestaciones:</strong> {{ optional($historia->ginecoobstetricos)->Gestaciones ?? '0' }}</p>
            <p><strong>Partos:</strong> {{ optional($historia->ginecoobstetricos)->Partos ?? '0' }}</p>
            <p><strong>Abortos:</strong> {{ optional($historia->ginecoobstetricos)->Abortos ?? '0' }}</p>
            <p><strong>Cesáreas:</strong> {{ optional($historia->ginecoobstetricos)->Cesareas ?? '0' }}</p>
        </div>
    </div>

    <div class="card shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <i class="bi bi-journal-medical"></i> Registrar Nota Médica
    </div>

    <div class="card-body">
        @include('notas._form_interno')
    </div>
</div>


<!-- Notas Médicas -->
@if($historia->notaMedicas && $historia->notaMedicas->count() > 0)
<div class="card shadow-sm mb-4">

    <!-- Encabezado moderno -->
    <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
        <h5 class="mb-0">
            <i class="bi bi-journal-medical"></i> Notas Médicas
        </h5>
        <span class="badge bg-light text-primary">Total: {{ $historia->notaMedicas->count() }}</span>
    </div>

    <div class="card-body">
        @foreach($historia->notaMedicas->sortByDesc('Fecha') as $nota)
        <div class="note-item p-3 mb-4 shadow-sm rounded border border-light" style="background:#fdfdfd;">
            
            <!-- Encabezado de nota -->
            <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                <h6 class="mb-0">
                    <i class="bi bi-calendar-check text-primary"></i>
                    {{ \Carbon\Carbon::parse($nota->Fecha)->format('d/m/Y') }} – {{ $nota->Hora }}
                </h6>
                <span class="badge bg-primary px-3 py-1">Nota Médica</span>
            </div>

            <!-- Datos principales -->
            <div class="row mb-3 text-muted">
                <div class="col-md-6 mb-2">
                    <i class="bi bi-person-lines-fill text-primary"></i>
                    <strong>Peso:</strong> {{ $nota->Peso ?? 'N/A' }} kg
                </div>
                <div class="col-md-6 mb-2">
                    <i class="bi bi-arrows-expand text-primary"></i>
                    <strong>Talla:</strong> {{ $nota->Talla ?? 'N/A' }} m
                </div>
            </div>

            <!-- Signos vitales -->
            <div class="row mb-3 text-muted">
                <div class="col-md-6 mb-2">
                    <i class="bi bi-heart-pulse text-danger"></i>
                    <strong>Presión Arterial:</strong> {{ $nota->Presion_Arterial ?? 'N/A' }}
                </div>
                <div class="col-md-6 mb-2">
                    <i class="bi bi-activity text-danger"></i>
                    <strong>Frecuencia Cardíaca:</strong> {{ $nota->Frecuencia_Cardiaca ?? 'N/A' }}
                </div>
            </div>

            <!-- Detalles clínicos -->
            <div class="mb-2">
                <p class="mb-1"><strong><i class="bi bi-clipboard2-pulse"></i> Exploración Física:</strong></p>
                <p class="text-muted">{{ $nota->Exploracion_Fisica ?? 'N/A' }}</p>
            </div>

            <div class="mb-2">
                <p class="mb-1"><strong><i class="bi bi-file-medical"></i> Diagnóstico:</strong></p>
                <p class="text-muted">{{ $nota->Diagnostico ?? 'N/A' }}</p>
            </div>

            <div class="mb-2">
                <p class="mb-1"><strong><i class="bi bi-capsule"></i> Tratamiento:</strong></p>
                <p class="text-muted">{{ $nota->Tratamiento ?? 'N/A' }}</p>
            </div>

            <div>
                <p class="mb-1"><strong><i class="bi bi-flag"></i> Plan a Seguir:</strong></p>
                <p class="text-muted">{{ $nota->Plan_A_Seguir ?? 'N/A' }}</p>
            </div>
        </div>
        @endforeach
    </div>
</div>

@else
<div class="alert alert-info shadow-sm">
    <i class="bi bi-info-circle"></i> No hay notas médicas registradas para esta historia clínica.
</div>
@endif



    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('historia.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver al listado
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: '¡Nota médica registrada!',
    text: '{{ session("success") }}',
    confirmButtonColor: '#198754'
});
</script>
@endif
</body>
</html>


