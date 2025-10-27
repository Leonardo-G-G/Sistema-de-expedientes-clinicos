<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Clínica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background: #f2f7fa; }
        .card { border-radius: 1rem; box-shadow: 0 4px 15px rgba(0,0,0,0.2); }
        .card-header { background-color: #007bff; color: white; font-size: 1.5rem; text-align: center; border-top-left-radius: 1rem; border-top-right-radius: 1rem; }
        .btn-primary { background-color: #007bff; border: none; }
        .btn-primary:hover { background-color: #0056b3; }
    </style>
</head>
<body>
<div class="container py-5" style="max-width: 500px;">
    <div class="card">
        <div class="card-header">Iniciar Sesión</div>
        <div class="card-body p-4">

            {{-- ✅ Mensaje de éxito al registrarse --}}
            @if (session('success'))
                <div class="alert alert-success text-center">
                    {{ session('success') }}
                </div>
            @endif

            {{-- ❌ Mensaje de error general --}}
            @if (session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            {{-- ⚠️ Errores de validación --}}
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- 📝 Formulario --}}
            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control" name="Correo_Electronico" value="{{ old('Correo_Electronico') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" type="password" class="form-control" name="Contraseña" required>
                </div>

                <div class="d-grid mb-2">
                    <button type="submit" class="btn btn-primary btn-lg rounded-3">Iniciar Sesión</button>
                </div>

                <p class="text-center text-muted mt-3">
                    ¿No tienes cuenta?
                    <a href="{{ route('register') }}" class="text-primary">Regístrate</a>
                </p>
            </form>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
