<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nota Médica - Sistema Clínico</title>
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
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            flex: 1;
        }
        header h1 {
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 2rem;
        }
        .form-control,
        .form-select,
        textarea {
            border-radius: 8px;
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

        <a href="{{ route('expedientes.index') }}" class="{{ request()->routeIs('expedientes.*') ? 'active' : '' }}">
            <i class="bi bi-folder-plus"></i> <span>Expedientes</span>
        </a>

        <a href="{{ route('historia.index') }}" class="{{ request()->routeIs('historia.*') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-medical"></i> <span>Historias Clínicas</span>
        </a>

        <a href="{{ route('pacientes.index') }}" class="{{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
            <i class="bi bi-person-lines-fill"></i> <span>Pacientes</span>
        </a>

        <a href="{{ route('notas.create') }}" class="{{ request()->routeIs('notas.create') ? 'active' : '' }}">
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

    <!-- Main Content -->
    <div class="main-content">
        <header>
            <h1>Registrar Nota Médica</h1>
        </header>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
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

        <!-- Formulario de Nota Médica -->
        <form action="{{ route('notas.store') }}" method="POST" class="card p-4 shadow-sm">
            @csrf

            @if(isset($historia) && $historia)
                <!-- Si viene desde una historia específica -->
                <input type="hidden" name="Historia_Id" value="{{ $historia->Id_Historia }}">

                <div class="mb-3">
                    <label class="form-label">Paciente</label>
                    <input type="text" class="form-control" 
                           value="{{ $historia->expediente->paciente->Nombre }} {{ $historia->expediente->paciente->Apellido }}" readonly>
                </div>

                <div class="mb-3">
                    <label class="form-label">Expediente</label>
                    <input type="text" class="form-control" 
                           value="{{ $historia->expediente->Numero_Expediente ?? $historia->Expediente_Id }}" readonly>
                </div>
            @else
                <!-- Si no viene historia, mostrar selector -->
                <div class="mb-3">
                    <label class="form-label">Historia Clínica</label>
                    <select name="Historia_Id" class="form-select" required>
                        <option value="">Seleccione una historia clínica</option>
                        @foreach ($historias as $item)
                            <option value="{{ $item->Id_Historia }}">
                                {{ $item->expediente->paciente->Nombre }} {{ $item->expediente->paciente->Apellido }}
                                — Exp: {{ $item->expediente->Numero_Expediente ?? $item->Expediente_Id }}
                            </option>
                        @endforeach
                    </select>
                </div>
            @endif

            <input type="hidden" name="Fecha" value="{{ now()->format('Y-m-d') }}">
            <input type="hidden" name="Hora" value="{{ now()->format('H:i') }}">

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Peso (kg)</label>
                    <input type="number" step="0.1" name="Peso" class="form-control" value="{{ old('Peso') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Talla (m)</label>
                    <input type="number" step="0.01" name="Talla" class="form-control" value="{{ old('Talla') }}">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Presión Arterial</label>
                    <input type="text" name="Presion_Arterial" class="form-control" value="{{ old('Presion_Arterial') }}">
                </div>
                <div class="col-md-6">
                    <label class="form-label">Frecuencia Cardíaca</label>
                    <input type="number" name="Frecuencia_Cardiaca" class="form-control" value="{{ old('Frecuencia_Cardiaca') }}">
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Impresión Diagnóstica</label>
                <textarea name="Impresion_Diagnostica" rows="3" class="form-control">{{ old('Impresion_Diagnostica') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Tratamiento</label>
                <textarea name="Tratamiento" rows="3" class="form-control">{{ old('Tratamiento') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Observaciones</label>
                <textarea name="Observacion" rows="3" class="form-control">{{ old('Observacion') }}</textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('historia.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Guardar Nota Médica
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
