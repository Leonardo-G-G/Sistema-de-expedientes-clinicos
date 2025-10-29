<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Expediente Clínico - Sistema Clínico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        #resultados { position: absolute; width: 100%; z-index: 1050; }
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
            <i class="bi bi-folder-plus"></i> <span>Crear Expediente</span>
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
            <h1>Crear Expediente Clínico</h1>
        </header>

        <!-- ✅ Mensaje de éxito -->
        @if(session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Éxito',
                    text: "{{ session('success') }}",
                    confirmButtonColor: '#198754'
                });
            </script>
        @endif

        <!-- ⚠️ Mensajes de error -->
        @if($errors->any())
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    html: `{!! implode('<br>', $errors->all()) !!}`,
                    confirmButtonColor: '#dc3545'
                });
            </script>
        @endif

        <form action="{{ route('expedientes.store') }}" method="POST">
            @csrf

            <div class="row mb-3">
                <!-- Campo de búsqueda dinámica -->
                <div class="col-md-6 position-relative">
                    <label for="buscar_paciente">Paciente</label>
                    <input type="text" id="buscar_paciente" class="form-control" placeholder="Escribe el nombre o apellido del paciente...">
                    <input type="hidden" name="Paciente_Id" id="paciente_id" required>
                    <div id="resultados" class="list-group mt-1 shadow-sm" style="display:none;"></div>
                </div>

                <div class="col-md-6">
                    <label>Médico responsable</label>
                    <input type="text" class="form-control" 
                           value="{{ Auth::user()->Nombre ?? Auth::user()->name }} {{ Auth::user()->Apellido ?? '' }}" 
                           readonly>
                </div>
            </div>

            <!-- Campos ocultos -->
            <input type="hidden" name="Fecha_Apertura" value="{{ now() }}">
            <input type="hidden" name="Estado_Expediente" value="Activo">

            <div class="d-flex justify-content-between">
                <a href="{{ route('expedientes.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Volver
                </a>
                <button type="submit" class="btn btn-success">
                    <i class="bi bi-save"></i> Guardar Expediente
                </button>
            </div>
        </form>
    </div>

    <!-- 🔎 Script búsqueda dinámica mejorada -->
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const input = document.getElementById('buscar_paciente');
        const lista = document.getElementById('resultados');
        const hidden = document.getElementById('paciente_id');
        let timeout = null;

        input.addEventListener('input', function() {
            const q = this.value.trim();
            clearTimeout(timeout);

            if (q.length < 2) {
                lista.style.display = 'none';
                return;
            }

            timeout = setTimeout(() => {
                // ✅ Ruta corregida usando route() de Blade
                fetch(`{{ route('expedientes.buscarPacientes') }}?q=${encodeURIComponent(q)}`)
                    .then(res => res.json())
                    .then(data => {
                        lista.innerHTML = '';
                        if (data.length > 0) {
                            data.forEach(p => {
                                const item = document.createElement('a');
                                item.href = '#';
                                item.classList.add('list-group-item', 'list-group-item-action');
                                item.textContent = `${p.Nombre} ${p.Apellido}`;
                                item.addEventListener('click', e => {
                                    e.preventDefault();
                                    input.value = `${p.Nombre} ${p.Apellido}`;
                                    hidden.value = p.Id_Paciente;
                                    lista.style.display = 'none';
                                });
                                lista.appendChild(item);
                            });
                            lista.style.display = 'block';
                        } else {
                            lista.style.display = 'none';
                        }
                    })
                    .catch(() => lista.style.display = 'none');
            }, 300);
        });

        document.addEventListener('click', e => {
            if (!lista.contains(e.target) && e.target !== input) {
                lista.style.display = 'none';
            }
        });
    });
    </script>

</body>
</html>
