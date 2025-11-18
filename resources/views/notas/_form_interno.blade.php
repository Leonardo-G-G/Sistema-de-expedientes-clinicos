<form action="{{ route('notas.store') }}" method="POST" id="formNotaInterno">
    @csrf

    <!-- 🆔 ID de historia recibido desde show.blade.php -->
    <input type="hidden" name="Historia_Id" value="{{ $historia->Id_Historia }}">

    <!-- 🕓 Fecha y hora -->
    <input type="hidden" name="Fecha" value="{{ now()->format('Y-m-d') }}">
    <input type="hidden" name="Hora" value="{{ now()->format('H:i') }}">

    <!-- Campos clínicos -->
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
        <label class="form-label">Exploración Física</label>
        <textarea name="Exploracion_Fisica" rows="3" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Diagnóstico</label>
        <textarea name="Diagnostico" rows="3" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Tratamiento</label>
        <textarea name="Tratamiento" rows="3" class="form-control"></textarea>
    </div>

    <div class="mb-3">
        <label class="form-label">Plan a Seguir</label>
        <textarea name="Plan_A_Seguir" rows="3" class="form-control"></textarea>
    </div>

    <div class="mt-3 text-end">
        <button type="submit" class="btn btn-success">
            <i class="bi bi-save"></i> Guardar Nota Médica
        </button>
    </div>
</form>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {

    const form = document.getElementById('formNotaInterno');

    form.addEventListener('submit', function(ev) {
        ev.preventDefault();

        Swal.fire({
            title: '¿Registrar nota médica?',
            text: 'Confirma que deseas guardar esta nota médica.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: 'Sí, guardar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#198754'
        }).then(result => {
            if (result.isConfirmed) {
                document.getElementById('formNotaInterno').submit(); // ✔ YA FUNCIONA
            }
        });
    });

});
</script>
