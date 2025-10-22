<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Clínica</title>
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
<div class="container py-5" style="max-width: 700px;">
    <div class="card">
        <div class="card-header">Registro de Usuario</div>
        <div class="card-body p-4">

            {{-- ✅ Mensaje de éxito --}}
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
            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input id="nombre" type="text" class="form-control" name="Nombre" value="{{ old('Nombre') }}" required autofocus>
                </div>

                <div class="mb-3">
                    <label for="apellido" class="form-label">Apellido</label>
                    <input id="apellido" type="text" class="form-control" name="Apellido" value="{{ old('Apellido') }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Correo Electrónico</label>
                    <input id="email" type="email" class="form-control" name="Correo_Electronico" value="{{ old('Correo_Electronico') }}" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Contraseña</label>
                    <input id="password" type="password" class="form-control" name="Contraseña" required>
                </div>

                {{-- ⚙️ Importante: debe coincidir con "Contraseña_confirmation" --}}
                <div class="mb-3">
                    <label for="password-confirm" class="form-label">Confirmar Contraseña</label>
                    <input id="password-confirm" type="password" class="form-control" name="Contraseña_confirmation" required>
                </div>

                <div class="mb-3">
                    <label for="rol" class="form-label">Rol</label>
                    <select id="rol" class="form-select" name="Rol_Id" required>
                        <option value="">Seleccionar rol</option>
                        <option value="1" {{ old('Rol_Id') == 1 ? 'selected' : '' }}>Administrador</option>
                        <option value="2" {{ old('Rol_Id') == 2 ? 'selected' : '' }}>Médico</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="cedula" class="form-label">Cédula Profesional</label>
                    <input id="cedula" type="text" class="form-control" name="Cedula_Profesional" value="{{ old('Cedula_Profesional') }}">
                </div>

                <div class="mb-3">
                    <label for="especialidad" class="form-label">Especialidad</label>
                    <input id="especialidad" type="text" class="form-control" name="Especialidad" value="{{ old('Especialidad') }}">
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
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
