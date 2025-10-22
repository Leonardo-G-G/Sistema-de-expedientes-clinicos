<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Dashboard - Clínica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5 text-center">
        <h1 class="mb-4">Bienvenido, {{ Auth::user()->Nombre }} 👋</h1>
        <p class="lead">Has iniciado sesión correctamente en el sistema de la clínica.</p>
        <a href="{{ route('logout') }}" class="btn btn-danger mt-4"
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
           Cerrar sesión
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
        </form>
    </div>
</body>
</html>
