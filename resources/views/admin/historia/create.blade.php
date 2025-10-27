<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Historia Clínica - Panel Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary: #0d6efd; --bg: #f5f7fa; --sidebar-width: 250px; }
        body { background-color: var(--bg); font-family: 'Segoe UI', sans-serif; display: flex; margin: 0; min-height: 100vh; }
        .sidebar { width: var(--sidebar-width); background: linear-gradient(180deg, #0d6efd, #003c99); color: white; display: flex; flex-direction: column; position: fixed; height: 100%; box-shadow: 3px 0 15px rgba(0,0,0,0.15); }
        .sidebar h2 { text-align: center; font-size: 1.4rem; font-weight: 600; padding: 1.2rem 0; border-bottom: 1px solid rgba(255,255,255,0.2); }
        .user-info { text-align: center; padding: 1rem; border-bottom: 1px solid rgba(255,255,255,0.2); }
        .user-info i { font-size: 3rem; color: #fff; }
        .sidebar a { color: white; text-decoration: none; display: flex; align-items: center; gap: 10px; padding: 0.9rem 1.5rem; transition: background 0.3s; font-weight: 500; }
        .sidebar a:hover, .sidebar a.active { background-color: rgba(255,255,255,0.15); }
        .main-content { margin-left: var(--sidebar-width); padding: 2rem; flex: 1; }
        header h1 { font-size: 1.8rem; font-weight: 700; color: #333; margin-bottom: 2rem; }
        .card { border-radius: 12px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); margin-bottom: 1.5rem; }
        .card-header { background-color: var(--primary); color: white; font-weight: 600; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <h2>Administrador</h2>

        <div class="user-info">
            <i class="bi bi-person-circle"></i>
            <p>{{ Auth::user()->Nombre ?? 'Admin' }}</p>
        </div>

        <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> Dashboard</a>
        <a href="{{ route('expedientes.create') }}"><i class="bi bi-folder-plus"></i> Crear Expediente</a>
        <a href="{{ route('historia.create') }}" class="active"><i class="bi bi-file-earmark-medical"></i> Historia Clínica</a>
        <a href="{{ route('pacientes.index') }}"><i class="bi bi-person-lines-fill"></i> Pacientes</a>
        <a href="{{ route('notas.create') }}" class="{{ request()->routeIs('notas.create') ? 'active' : '' }}">
    <i class="bi bi-journal-medical"></i> <span>Nota Médica</span>
</a>

        <a href="#"><i class="bi bi-hospital"></i> <span>Médicos</span></a>

        <form action="{{ route('logout') }}" method="POST" class="mt-auto text-center">
            @csrf
            <button type="submit" class="btn btn-danger mt-3">
                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
            </button>
        </form>
    </aside>

    <!-- Main content -->
    <div class="main-content">
        <header>
            <h1>Registrar Historia Clínica</h1>
        </header>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('historia.store') }}" method="POST">
            @csrf

            <!-- Datos generales -->
            <div class="card">
                <div class="card-header">Datos Generales</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label>Seleccione expediente</label>
                        <select name="Expediente_Id" class="form-select" required>
                            <option value="">Seleccione un expediente</option>
                            @foreach($expedientes as $expediente)
                                <option value="{{ $expediente->Id_Expediente }}">Expediente #{{ $expediente->Id_Expediente }} - {{ $expediente->paciente->Nombre }} {{ $expediente->paciente->Apellido }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Padecimiento Actual</label>
                        <textarea name="Padecimiento_Actual" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Exploración Física</label>
                        <textarea name="Exploracion_Fisica" class="form-control" rows="3"></textarea>
                    </div>

                    <div class="mb-3">
                        <label>Diagnóstico</label>
                        <textarea name="Diagnostico" class="form-control" rows="3"></textarea>
                    </div>
                </div>
            </div>

            <!-- Antecedentes heredofamiliares -->
            <div class="card">
                <div class="card-header">Antecedentes Heredofamiliares</div>
                <div class="card-body">
                    <div class="row">
                        @foreach(['Diabetes', 'Hipertension', 'Cancer', 'Trastornos_Mentales', 'Enfermedades_Cronicas'] as $campo)
                            <div class="col-md-4 mb-3">
                                <label>{{ str_replace('_', ' ', $campo) }}</label>
                                <select name="heredofamiliares[{{ $campo }}]" class="form-select">
                                    <option value="No">No</option>
                                    <option value="Sí">Sí</option>
                                </select>
                            </div>
                        @endforeach
                    </div>
                    <div class="mb-3">
                        <label>Otros</label>
                        <input type="text" name="heredofamiliares[Otros]" class="form-control">
                    </div>
                </div>
            </div>

            <!-- Antecedentes patológicos -->
            <div class="card">
                <div class="card-header">Antecedentes Patológicos</div>
                <div class="card-body">
                    @foreach(['Cirugias', 'Alergias', 'Hospitalizaciones', 'Enfermedades_Infecciosas', 'Transfusiones'] as $campo)
                        <div class="mb-3">
                            <label>{{ str_replace('_', ' ', $campo) }}</label>
                            <textarea name="patologicos[{{ $campo }}]" class="form-control" rows="2"></textarea>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Antecedentes no patológicos -->
            <div class="card">
                <div class="card-header">Antecedentes No Patológicos</div>
                <div class="card-body">
                    @foreach(['Tipo_Vivienda', 'Religion', 'Alimentacion', 'Actividad_Fisica'] as $campo)
                        <div class="mb-3">
                            <label>{{ str_replace('_', ' ', $campo) }}</label>
                            <input type="text" name="no_patologicos[{{ $campo }}]" class="form-control">
                        </div>
                    @endforeach
                    @foreach(['Tabaquismo', 'Alcoholismo', 'Drogas'] as $campo)
                        <div class="col-md-4 mb-3">
                            <label>{{ $campo }}</label>
                            <select name="no_patologicos[{{ $campo }}]" class="form-select">
                                <option value="No">No</option>
                                <option value="Sí">Sí</option>
                            </select>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Guardar Historia Clínica
                </button>
            </div>
        </form>
    </div>

</body>
</html>
