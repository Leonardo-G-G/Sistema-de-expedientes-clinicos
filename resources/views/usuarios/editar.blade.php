@extends('layouts.app')

@section('titulo', 'Editar Perfil')
@section('icono')
    <i class="bi bi-person-circle text-primary"></i>
@endsection
@section('usuario_active', 'active')

@section('contenido')
    <div class="card mx-auto" style="max-width: 650px;">
        <div class="card-header">
            <i class="bi bi-pencil-square"></i> Editar Perfil
        </div>

        <div class="card-body">
            <form action="{{ route('usuario.actualizar') }}" method="POST" id="formPerfil">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="Nombre" class="form-label fw-semibold">Nombre</label>
                    <input type="text" name="Nombre" id="Nombre" class="form-control"
                           value="{{ old('Nombre', $usuario->Nombre) }}" required>
                </div>

                <div class="mb-3">
                    <label for="Apellido" class="form-label fw-semibold">Apellido</label>
                    <input type="text" name="Apellido" id="Apellido" class="form-control"
                           value="{{ old('Apellido', $usuario->Apellido) }}" required>
                </div>

                <div class="mb-3">
                    <label for="Correo_Electronico" class="form-label fw-semibold">Correo Electrónico</label>
                    <input type="email" name="Correo_Electronico" id="Correo_Electronico" class="form-control"
                           value="{{ old('Correo_Electronico', $usuario->Correo_Electronico) }}" required>
                </div>

                <div class="mb-3">
                    <label for="Especialidad" class="form-label fw-semibold">Especialidad</label>
                    <input type="text" name="Especialidad" id="Especialidad" class="form-control"
                           value="{{ old('Especialidad', $usuario->Especialidad) }}">
                </div>

                <div class="mb-3">
                    <label for="Contraseña" class="form-label fw-semibold">Contraseña (opcional)</label>
                    <input type="password" name="Contraseña" id="Contraseña" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="Contraseña_confirmation" class="form-label fw-semibold">Confirmar Contraseña</label>
                    <input type="password" name="Contraseña_confirmation" id="Contraseña_confirmation" class="form-control">
                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn btn-success me-2">
                        <i class="bi bi-check-circle"></i> Guardar Cambios
                    </button>
                    <a href="{{ route('usuario.perfil') }}" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <footer class="text-center mt-4 text-muted small">
        © {{ date('Y') }} Clínica Quirúrgica Téran — Sistema Clínico
    </footer>

    {{-- ✅ SweetAlert2 para mostrar éxito --}}
    @if(session('success'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: '¡Perfil actualizado!',
                text: '{{ session('success') }}',
                confirmButtonColor: '#198754',
                timer: 2500,
                showConfirmButton: false
            });
        </script>
    @endif
@endsection
