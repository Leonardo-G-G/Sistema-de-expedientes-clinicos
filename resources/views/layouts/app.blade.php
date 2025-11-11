<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('titulo', 'Sistema Clínico')</title>

    <!-- Bootstrap y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --primary: #0077b6;
            --primary-dark: #023e8a;
            --bg: #edf2f7;
            --card-bg: #ffffff;
            --shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        body {
            background: var(--bg);
            font-family: "Poppins", sans-serif;
            margin: 0;
            min-height: 100vh;
            display: flex;
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
            transition: transform 0.3s ease;
        }

        .sidebar.collapsed {
            transform: translateX(-100%);
        }

        .sidebar h2 {
            text-align: center;
            padding: 1.4rem 0;
            font-size: 1.6rem;
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
            width: 100%;
            transition: margin-left 0.3s ease;
        }

        .main-content.full-width {
            margin-left: 0;
        }

        header {
            background: linear-gradient(90deg, var(--primary-dark), var(--primary));
            color: white;
            padding: 1.2rem 1.8rem;
            border-radius: 16px;
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        header h1 {
            font-size: 1.6rem;
            font-weight: 600;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .menu-toggle {
            display: none;
            background: none;
            border: none;
            color: #fff;
            font-size: 1.8rem;
        }

        .card {
            border: none;
            border-radius: 16px;
            background: var(--card-bg);
            box-shadow: var(--shadow);
            padding: 1.5rem;
        }

        footer {
            text-align: center;
            margin-top: 2rem;
            color: #777;
            font-size: 0.9rem;
        }

        /* RESPONSIVE */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
                z-index: 1000;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .menu-toggle {
                display: inline-block;
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            header h1 {
                font-size: 1.3rem;
            }
        }
    </style>
</head>

<body>
    <!-- SIDEBAR -->
    <aside class="sidebar" id="sidebar">
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
            <i class="bi bi-file-earmark-medical"></i> Historia Clínica
        </a>

        <a href="{{ route('pacientes.index') }}" class="{{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
            <i class="bi bi-person-lines-fill"></i> Pacientes
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

    <!-- CONTENIDO PRINCIPAL -->
    <div class="main-content" id="main">
        <header>
            <h1>
                @hasSection('icono')
                    {!! trim($__env->yieldContent('icono')) !!}
                @endif
                @yield('titulo')
            </h1>
            <button class="menu-toggle" id="menu-toggle"><i class="bi bi-list"></i></button>
        </header>

        <main>
            @yield('contenido')
        </main>

        <footer>
            <p>© {{ date('Y') }} Clínica Quirúrgica Téran — Sistema Clínico</p>
        </footer>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Menú colapsable en móviles
        const toggle = document.getElementById('menu-toggle');
        const sidebar = document.getElementById('sidebar');
        const main = document.getElementById('main');

        toggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
        });
    </script>
</body>
</html>
