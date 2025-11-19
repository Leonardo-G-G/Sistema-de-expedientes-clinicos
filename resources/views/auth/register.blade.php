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
        max-width: 480px;
        border-radius: 1rem;
        box-shadow: 0 8px 25px rgba(0,0,0,0.2);
        transition: transform 0.3s ease;
    }
    .card:hover { transform: translateY(-5px); }
    .card-header {
        background: linear-gradient(to right, #0d6efd, #6610f2);
        color: white;
        font-size: 1.5rem;
        text-align: center;
        padding: 1rem;
        font-weight: 500;
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
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register') }}">
            @csrf

            <!-- Nombre -->
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control" name="Nombre"
                    value="{{ old('Nombre') }}" required>
                </div>
            </div>

            <!-- Apellido -->
            <div class="mb-3">
                <label class="form-label">Apellido</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-person"></i></span>
                    <input type="text" class="form-control" name="Apellido"
                    value="{{ old('Apellido') }}" required>
                </div>
            </div>

            <!-- Correo -->
            <div class="mb-3">
                <label class="form-label">Correo Electrónico</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                    <input type="email" class="form-control" name="email"
                    value="{{ old('email') }}" required>
                </div>
            </div>

            <!-- Contraseña -->
            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input id="password" type="password" class="form-control" name="password" required>
                    <span class="input-group-text" onclick="togglePassword('password', this)">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>
            </div>

            <!-- Confirmar contraseña -->
            <div class="mb-3">
                <label class="form-label">Confirmar Contraseña</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock"></i></span>
                    <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                    <span class="input-group-text" onclick="togglePassword('password-confirm', this)">
                        <i class="bi bi-eye"></i>
                    </span>
                </div>
            </div>

            <!-- Cédula -->
            <div class="mb-3">
                <label class="form-label">Cédula Profesional</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-card-text"></i></span>
                    <input type="text" class="form-control" name="Cedula_Profesional"
                    value="{{ old('Cedula_Profesional') }}">
                </div>
            </div>

            <!-- Especialidad -->
            <div class="mb-3">
                <label class="form-label">Especialidad</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-briefcase"></i></span>
                    <input type="text" class="form-control" name="Especialidad"
                    value="{{ old('Especialidad') }}">
                </div>
            </div>

            <!-- Botón -->
            <div class="d-grid mt-3">
                <button type="submit" class="btn btn-primary btn-lg rounded-3">
                    Registrarse
                </button>
            </div>

            <p class="text-center mt-3 text-muted">
                ¿Ya tienes cuenta?
                <a href="{{ route('login') }}" class="text-primary">Iniciar sesión</a>
            </p>

        </form>
    </div>
</div>

<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.replace('bi-eye', 'bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.replace('bi-eye-slash', 'bi-eye');
    }
}
</script>

</body>
</html>
