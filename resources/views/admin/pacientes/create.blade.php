<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Paciente - Panel Admin</title>
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
        <a href="{{ route('pacientes.create') }}" class="active"><i class="bi bi-person-lines-fill"></i> <span>Pacientes</span></a>
        <a href="#"><i class="bi bi-hospital"></i> <span>Médicos</span></a>

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
            <h1>Registrar Paciente</h1>
        </header>

        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('pacientes.store') }}" method="POST">
            @csrf
            <div class="row mb-3">
                <div class="col-md-6">
                    <label>Nombre</label>
                    <input type="text" name="Nombre" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label>Apellido</label>
                    <input type="text" name="Apellido" class="form-control" required>
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label>Sexo</label>
                    <select name="Sexo" class="form-select">
                        <option value="">Selecciona</option>
                        <option>Masculino</option>
                        <option>Femenino</option>
                        <option>Otro</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Fecha de nacimiento</label>
                    <input type="date" name="Fecha_Nacimiento" class="form-control">
                </div>
                <div class="col-md-4">
                    <label>Teléfono</label>
                    <input type="text" name="Telefono" class="form-control">
                </div>
            </div>

            <div class="mb-3">
                <label>Lugar de origen</label>
                <input type="text" name="Lugar_Origen" class="form-control">
            </div>
            <div class="mb-3">
                <label>Contacto de emergencia</label>
                <input type="text" name="Contacto_Emergencia" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>
    </div>

</body>
</html>
