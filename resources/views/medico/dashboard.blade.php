<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Médico</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background-color: #e9f2f7;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        .navbar-custom {
            background-color: #0d6efd;
        }
        .navbar-custom .navbar-brand,
        .navbar-custom .nav-link,
        .navbar-custom .dropdown-toggle {
            color: white;
        }
        .sidebar {
            height: 100vh;
            background-color: #fff;
            border-right: 1px solid #ddd;
            padding-top: 20px;
        }
        .sidebar a {
            display: block;
            padding: 12px 20px;
            color: #0d6efd;
            text-decoration: none;
            font-weight: 500;
        }
        .sidebar a:hover {
            background-color: #f0f5fa;
            border-radius: 8px;
        }
        .content {
            padding: 30px;
        }
        .card-dashboard {
            border-radius: 12px;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .card-dashboard:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
        }
    </style>
</head>
<body>

<!-- Navbar superior -->
<nav class="navbar navbar-expand-lg navbar-custom px-4">
    <a class="navbar-brand" href="#">Panel Médico</a>
    <div class="ms-auto dropdown">
        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            Dr. {{ Auth::user()->Nombre }}
        </a>
        <ul class="dropdown-menu dropdown-menu-end">
            <li>
                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right"></i> Cerrar sesión
                </a>
            </li>
        </ul>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">

        <!-- Sidebar -->
        <div class="col-md-2 sidebar">
            <a href="#"><i class="bi bi-people-fill me-2"></i>Pacientes</a>
            <a href="#"><i class="bi bi-calendar-check-fill me-2"></i>Citas</a>
            <a href="#"><i class="bi bi-file-medical-fill me-2"></i>Expedientes</a>
            <a href="#"><i class="bi bi-bar-chart-fill me-2"></i>Estadísticas</a>
        </div>

        <!-- Contenido principal -->
        <div class="col-md-10 content">
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="card card-dashboard p-4 text-center bg-white">
                        <i class="bi bi-people-fill display-4 text-primary mb-3"></i>
                        <h5>Pacientes</h5>
                        <p>Ver y administrar pacientes.</p>
                        <a href="#" class="btn btn-primary btn-sm">Ir a Pacientes</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-dashboard p-4 text-center bg-white">
                        <i class="bi bi-calendar-check-fill display-4 text-success mb-3"></i>
                        <h5>Citas</h5>
                        <p>Programar y revisar citas médicas.</p>
                        <a href="#" class="btn btn-success btn-sm">Ir a Citas</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-dashboard p-4 text-center bg-white">
                        <i class="bi bi-file-medical-fill display-4 text-warning mb-3"></i>
                        <h5>Expedientes</h5>
                        <p>Acceso a historiales clínicos.</p>
                        <a href="#" class="btn btn-warning btn-sm text-white">Ver Expedientes</a>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card card-dashboard p-4 text-center bg-white">
                        <i class="bi bi-bar-chart-fill display-4 text-info mb-3"></i>
                        <h5>Estadísticas</h5>
                        <p>Analizar rendimiento y citas.</p>
                        <a href="#" class="btn btn-info btn-sm text-white">Ver Estadísticas</a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>