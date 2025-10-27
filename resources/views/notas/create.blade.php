<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Nota Médica - Panel Admin</title>
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
        header h1 { font-size: 1.8rem; font-weight: 700; color: #333; margin-bottom: 2rem; }
        .form-control, .form-select { border-radius: 8px; }
        .card { border: none; border-radius: 15px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
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

        <a href="{{ route('admin.dashboard') }}"><i class="bi bi-speedometer2"></i> <span>Dashboard</span></a>
        <a href="{{ route('expedientes.create') }}"><i class="bi bi-folder-plus"></i> <span>Crear Expediente</span></a>
        <a href="{{ route('historia.create') }}"><i class="bi bi-file-earmark-medical"></i> <span>Historia Clínica</span></a>
        <a href="{{ route('notas.create') }}" class="active"><i class="bi bi-journal-medical"></i> <span>Nota Médica</span></a>
        <a href="{{ route('pacientes.index') }}"><i class="bi bi-person-lines-fill"></i> <span>Pacientes</span></a>
        <a href="#"><i class="bi bi-hospital"></i> <span>Médicos</span></a>

        <form action="{{ route('logout') }}" method="POST" class="mt-auto text-center">
            @csrf
            <button type="submit" class="logout-btn">
                <i class="bi bi-box-arrow-right"></i> Cerrar sesión
            </button>
        </form>
    </aside>

    <!-- Contenido principal -->
    <div class="main-content">
        <header>
            <h1><i class="bi bi-journal-medical"></i> Registrar Nota Médica</h1>
        </header>

        <div class="card p-4">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @elseif(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <form action="{{ route('notas.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="Expediente_Id" class="form-label">Expediente Clínico</label>
                    <select class="form-select" name="Expediente_Id" required>
                        <option value="">Seleccione un expediente...</option>
                        @foreach($expedientes as $exp)
                            <option value="{{ $exp->Id_Expediente }}">
                                ID {{ $exp->Id_Expediente }} — Paciente: {{ $exp->paciente->Nombre ?? 'Sin nombre' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="Fecha" class="form-label">Fecha</label>
                        <input type="date" name="Fecha" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="Hora" class="form-label">Hora</label>
                        <input type="time" name="Hora" class="form-control" required>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="Diagnostico" class="form-label">Diagnóstico</label>
                    <textarea name="Diagnostico" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="Tratamiento" class="form-label">Tratamiento</label>
                    <textarea name="Tratamiento" class="form-control" rows="3" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="Pronostico" class="form-label">Pronóstico</label>
                    <textarea name="Pronostico" class="form-control" rows="3"></textarea>
                </div>

                <div class="mb-3">
                    <label for="Observacion" class="form-label">Observaciones</label>
                    <textarea name="Observacion" class="form-control" rows="2"></textarea>
                </div>

                <div class="text-end">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Guardar Nota Médica
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
