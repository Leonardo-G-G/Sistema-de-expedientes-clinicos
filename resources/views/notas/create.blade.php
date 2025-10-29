<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nota Médica - Sistema Clínico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        .logout-btn {
            margin: 1.2rem;
            background-color: #dc3545;
            border: none;
            color: white;
            padding: 0.6rem 1rem;
            border-radius: 8px;
            font-weight: 500;
        }
        .main-content {
            margin-left: var(--sidebar-width);
            padding: 2rem;
            flex: 1;
        }
        #resultadosHistorias {
            max-height: 250px;
            overflow-y: auto;
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
    <a href="{{ route('pacientes.index') }}" class="{{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
        <i class="bi bi-person-lines-fill"></i> Pacientes
    </a>
    <a href="{{ route('notas.index') }}" class="active">
        <i class="bi bi-journal-medical"></i> Nota Médica
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
        <h1>Registrar Nota Médica</h1>
    </header>

    <form action="{{ route('notas.store') }}" method="POST" class="card p-4 shadow-sm" id="formNota">
        @csrf

        <div class="mb-3 position-relative">
            <label class="form-label">Buscar Historia Clínica</label>
            <input type="text" id="buscar_historia" class="form-control" placeholder="Nombre o Apellido del paciente">
            <input type="hidden" name="Historia_Id" id="Historia_Id" required>
            <div id="resultadosHistorias" class="list-group position-absolute w-100 mt-1" style="z-index:1050; display:none;"></div>
        </div>

        <input type="hidden" name="Fecha" value="{{ now()->format('Y-m-d') }}">
        <input type="hidden" name="Hora" value="{{ now()->format('H:i') }}">

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Peso (kg)</label>
                <input type="number" step="0.1" name="Peso" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Talla (m)</label>
                <input type="number" step="0.01" name="Talla" class="form-control">
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-md-6">
                <label class="form-label">Presión Arterial</label>
                <input type="text" name="Presion_Arterial" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">Frecuencia Cardíaca</label>
                <input type="number" name="Frecuencia_Cardiaca" class="form-control">
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Impresión Diagnóstica</label>
            <textarea name="Impresion_Diagnostica" rows="3" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Tratamiento</label>
            <textarea name="Tratamiento" rows="3" class="form-control"></textarea>
        </div>

        <div class="mb-3">
            <label class="form-label">Observaciones</label>
            <textarea name="Observacion" rows="3" class="form-control"></textarea>
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

<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('buscar_historia');
    const lista = document.getElementById('resultadosHistorias');
    const hidden = document.getElementById('Historia_Id');

    input.addEventListener('input', async function() {
        const q = this.value.trim();
        if (q.length < 2) { lista.style.display = 'none'; return; }

        try {
            const res = await fetch(`/buscar-historias?q=${encodeURIComponent(q)}`);
            const data = await res.json();
            lista.innerHTML = '';
            if(data.length > 0) {
                data.forEach(h => {
                    const item = document.createElement('a');
                    item.href = '#';
                    item.classList.add('list-group-item', 'list-group-item-action');
                    item.textContent = `${h.Nombre} ${h.Apellido} — Historia #${h.Id_Historia}`;
                    item.addEventListener('click', ev => {
                        ev.preventDefault();
                        input.value = `${h.Nombre} ${h.Apellido}`;
                        hidden.value = h.Id_Historia;
                        lista.style.display = 'none';
                    });
                    lista.appendChild(item);
                });
                lista.style.display = 'block';
            } else {
                lista.innerHTML = '<div class="list-group-item text-muted">No se encontraron resultados</div>';
                lista.style.display = 'block';
            }
        } catch (err) {
            console.error(err);
            lista.style.display = 'none';
        }
    });

    document.addEventListener('click', e => {
        if (!lista.contains(e.target) && e.target !== input)
            lista.style.display = 'none';
    });

    document.getElementById('formNota').addEventListener('submit', function(ev) {
        if (!hidden.value) {
            ev.preventDefault();
            Swal.fire({
                icon: 'error',
                title: 'Selecciona una historia clínica',
                text: 'Debes elegir una historia clínica antes de registrar la nota médica.'
            });
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
