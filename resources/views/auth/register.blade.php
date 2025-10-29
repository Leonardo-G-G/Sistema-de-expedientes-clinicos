<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registro - Sistema Clínico</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<style>
    body {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f2f7fa;
        font-family: 'Segoe UI', sans-serif;
        padding: 20px;
    }
    .card {
        width: 100%;
        max-width: 480px; /* ancho máximo para evitar corte */
        border-radius: 1rem;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        overflow: hidden;
        transition: transform 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
    }
    .card-header {
        background: linear-gradient(to right, #0d6efd, #6610f2);
        color: white;
        font-size: 1.5rem;
        text-align: center;
        padding: 1rem;
        font-weight: 500;
    }
    .form-control:focus {
        border-color: #6610f2;
        box-shadow: 0 0 0 0.2rem rgba(102,16,242,.25);
    }
    .input-group-text {
        background: transparent;
        border-left: none;
        cursor: pointer;
        min-width: 45px;
        justify-content: center;
    }
    .input-group .form-control {
        border-right: 0;
    }
    .btn-primary {
        background: linear-gradient(to right, #6610f2, #0d6efd);
        border: none;
        font-weight: 500;
        transition: background 0.3s ease;
    }
    .btn-primary:hover {
        background: linear-gradient(to right, #0d6efd, #6610f2);
    }
</style>
</head>
<body>

<div class="card">
    <div class="card-header">Registro de Usuario</div>
    <div class="card-body p-4">

        {{-- Mensajes --}}
        @if (session('success'))
            <div class="alert alert-success text-center">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger text-center">{{ session('error') }}</div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nombre -->
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input id="nombre" type="text" class="form-control" name="Nombre" value="{{ old('Nombre') }}" required autofocus>
                </div>
            </div>

            <!-- Apellido -->
            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input id="apellido" type="text" class="form-control" name="Apellido" value="{{ old('Apellido') }}" required>
                </div>
            </div>

            <!-- Correo -->
            <div class="mb-3">
                <label for="email" class="form-label">Correo Electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input id="email" type="email" class="form-control" name="Correo_Electronico" value="{{ old('Correo_Electronico') }}" required>
                </div>
            </div>

            <!-- Contraseña -->
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input id="password" type="password" class="form-control" name="Contraseña" required>
                    <span class="input-group-text" onclick="togglePassword('password', this)"><i class="bi bi-eye"></i></span>
                </div>
            </div>

            <!-- Confirmar Contraseña -->
            <div class="mb-3">
                <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input id="password-confirm" type="password" class="form-control" name="Contraseña_confirmation" required>
                    <span class="input-group-text" onclick="togglePassword('password-confirm', this)"><i class="bi bi-eye"></i></span>
                </div>
            </div>

            <!-- Cédula -->
            <div class="mb-3">
                <label for="cedula" class="form-label">Cédula Profesional</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                    <input id="cedula" type="text" class="form-control" name="Cedula_Profesional" value="{{ old('Cedula_Profesional') }}">
                </div>
            </div>

            <!-- Especialidad -->
            <div class="mb-3">
                <label for="especialidad" class="form-label">Especialidad</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                    <input id="especialidad" type="text" class="form-control" name="Especialidad" value="{{ old('Especialidad') }}">
                </div>
            </div>

            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-primary btn-lg rounded-3">Registrarse</button>
            </div>

            <p class="text-center mt-3 text-muted">
                ¿Ya tienes cuenta? <a href="{{ route('login') }}" class="text-primary">Iniciar sesión</a>
            </p>
        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if(input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}
</script>
</body>
</html>
