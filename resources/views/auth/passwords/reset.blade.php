<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Restablecer Contraseña</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

<style>
    body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        background: #f2f7fa;
        font-family: 'Segoe UI', sans-serif;
    }
    .card {
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
</style>
</head>
<body>

<div class="container" style="max-width: 450px;">
    <div class="card">
        <div class="card-header">Nueva Contraseña</div>

        <div class="card-body p-4">

            {{-- Errores --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                {{-- Token obligatorio --}}
                <input type="hidden" name="token" value="{{ $token }}">

                {{-- Email --}}
                <div class="mb-3">
                    <label class="form-label">Correo Electrónico</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input 
                            type="email" 
                            name="email" 
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ $email ?? old('email') }}" 
                            placeholder="Ingresa tu correo"
                            required
                            autofocus
                        >
                    </div>
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Nueva contraseña --}}
                <div class="mb-3">
                    <label class="form-label">Nueva Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input 
                            id="password" 
                            type="password" 
                            name="password" 
                            class="form-control" 
                            placeholder="Ingresa tu nueva contraseña"
                            required
                        >
                        <span class="input-group-text" onclick="togglePassword('password', this)">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                {{-- Confirmar contraseña --}}
                <div class="mb-3">
                    <label class="form-label">Confirmar Contraseña</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input 
                            id="password_confirmation" 
                            type="password" 
                            name="password_confirmation" 
                            class="form-control" 
                            placeholder="Confirma tu contraseña"
                            required
                        >
                        <span class="input-group-text" onclick="togglePassword('password_confirmation', this)">
                            <i class="bi bi-eye"></i>
                        </span>
                    </div>
                </div>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary btn-lg rounded-3">
                        Restablecer Contraseña
                    </button>
                </div>
            </form>

            <p class="text-center mt-3">
                <a href="{{ route('login') }}" class="text-primary">Volver al inicio de sesión</a>
            </p>
        </div>
    </div>
</div>

<script>
function togglePassword(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if(input.type === 'password') {
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
