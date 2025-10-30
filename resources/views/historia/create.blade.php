<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Registrar Historia Clínica</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
:root { --primary: #0d6efd; --bg: #f5f7fa; --sidebar-width: 250px; }
body { display: flex; margin: 0; min-height: 100vh; font-family: 'Segoe UI', sans-serif; background-color: var(--bg); }
.sidebar { width: var(--sidebar-width); background: linear-gradient(180deg, #0d6efd, #003c99); color: white; display: flex; flex-direction: column; position: fixed; height: 100%; }
.sidebar h2 { text-align: center; padding: 1rem 0; border-bottom: 1px solid rgba(255,255,255,0.2); }
.user-info { text-align: center; padding: 1rem; border-bottom: 1px solid rgba(255,255,255,0.2); }
.sidebar a { color: white; text-decoration: none; display: flex; align-items: center; gap: 10px; padding: 0.8rem 1.5rem; font-weight: 500; }
.sidebar a.active, .sidebar a:hover { background-color: rgba(255,255,255,0.15); }
.main-content { margin-left: var(--sidebar-width); padding: 2rem; flex: 1; }
.card { border-radius: 12px; margin-bottom: 1.5rem; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
.card-header { background-color: var(--primary); color: white; font-weight: 600; }
#resultados { max-height: 250px; overflow-y: auto; }
</style>
</head>
<body>

<!-- Sidebar -->
<aside class="sidebar">
<h2>Sistema Clínico</h2>
<div class="user-info">
<i class="bi bi-person-circle fs-2"></i>
<p>{{ Auth::user()->name ?? 'Admin' }}</p>
</div>
<a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <i class="bi bi-speedometer2"></i> Dashboard
</a>
<a href="{{ route('expedientes.index') }}" class="{{ request()->routeIs('expedientes.*') ? 'active' : '' }}">
    <i class="bi bi-folder2-open"></i> Expedientes
</a>
<a href="{{ route('historia.index') }}" class="active">
    <i class="bi bi-file-earmark-medical"></i> Historia Clínica
</a>
<a href="{{ route('pacientes.index') }}" class="{{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
    <i class="bi bi-people"></i> Pacientes
</a>
<a href="{{ route('notas.index') }}" class="{{ request()->routeIs('notas.*') ? 'active' : '' }}">
    <i class="bi bi-journal-medical"></i> Notas Médicas
</a>
<a href="{{ route('usuario.perfil') }}" class="{{ request()->routeIs('usuario.*') ? 'active' : '' }}">
    <i class="bi bi-person-circle"></i> Perfil
</a>
<form action="{{ route('logout') }}" method="POST" class="mt-auto text-center">
@csrf
<button type="submit" class="btn btn-danger mt-3">
<i class="bi bi-box-arrow-right"></i> Cerrar sesión
</button>
</form>
</aside>

<!-- Contenido principal -->
<div class="main-content">
<header>
<h1>Registrar Historia Clínica</h1>
</header>

@if(session('success'))
<script>
Swal.fire({ icon: 'success', title: 'Éxito', text: '{{ session("success") }}' });
</script>
@endif
@if($errors->any())
<script>
Swal.fire({ icon: 'error', title: 'Error', html: `{!! implode('<br>', $errors->all()) !!}` });
</script>
@endif

<form id="formHistoria" action="{{ route('historia.store') }}" method="POST">
@csrf

<!-- Datos Generales -->
<div class="card">
<div class="card-header">Datos Generales</div>
<div class="card-body">
    <div class="col-md-6 position-relative mb-4">
        <label for="buscar_paciente" class="form-label">Buscar Paciente</label>
        <input type="text" id="buscar_paciente" class="form-control" placeholder="Nombre o Apellido">
        <input type="hidden" name="Expediente_Id" id="Expediente_Id" required>
        <div id="resultados" class="list-group mt-1 position-absolute w-100" style="z-index:1050; display:none;"></div>
    </div>

    
</div>
</div>

<!-- Antecedentes Heredofamiliares -->
<div class="card">
<div class="card-header">Antecedentes Heredofamiliares</div>
<div class="card-body row">
@foreach(['Diabetes','Hipertension','Cancer'] as $campo)
<div class="col-md-4 mb-3">
<label class="form-label">{{ $campo }}</label>
<select name="heredofamiliares[{{ $campo }}]" class="form-select">
<option value="0">No</option>
<option value="1">Sí</option>
</select>
</div>
@endforeach
<div class="col-md-6 mb-3">
<label class="form-label">Enfermedades Crónicas</label>
<input type="text" name="heredofamiliares[Enfermedades_Cronicas]" class="form-control">
</div>
<div class="col-md-6 mb-3">
<label class="form-label">Otros</label>
<input type="text" name="heredofamiliares[Otros]" class="form-control">
</div>
</div>
</div>

<!-- Antecedentes No Patológicos -->
<div class="card">
<div class="card-header">Antecedentes No Patológicos</div>
<div class="card-body row">
@foreach(['Tipo_Vivienda','Religion','Alimentacion','Actividad_Fisica'] as $campo)
<div class="col-md-6 mb-3">
<label class="form-label">{{ str_replace('_',' ',$campo) }}</label>
<input type="text" name="no_patologicos[{{ $campo }}]" class="form-control">
</div>
@endforeach
@foreach(['Tabaquismo','Alcoholismo','Drogas'] as $campo)
<div class="col-md-4 mb-3">
<label class="form-label">{{ $campo }}</label>
<select name="no_patologicos[{{ $campo }}]" class="form-select">
<option value="0">No</option>
<option value="1">Sí</option>
</select>
</div>
@endforeach
</div>
</div>

<!-- Antecedentes Patológicos -->
<div class="card">
<div class="card-header">Antecedentes Patológicos</div>
<div class="card-body">
<label class="form-label">Descripción</label>
<textarea name="patologicos[Descripcion]" class="form-control" rows="3"></textarea>
</div>
</div>

<!-- Ginecoobstétricos -->
<div class="card">
<div class="card-header">Antecedentes Ginecoobstétricos</div>
<div class="card-body row">
<div class="col-md-3 mb-3">
<label class="form-label">Menarca (Edad)</label>
<input type="number" name="ginecoobstetricos[Menarca_Edad]" class="form-control">
</div>
<div class="col-md-3 mb-3">
<label class="form-label">Tipo de Ciclo</label>
<input type="text" name="ginecoobstetricos[Tipo_Ciclo]" class="form-control">
</div>
<div class="col-md-3 mb-3">
<label class="form-label">Ciclos Dolorosos</label>
<select name="ginecoobstetricos[Ciclos_Dolor]" class="form-select">
<option value="1">Sí</option>
<option value="0">No</option>
</select>
</div>
<div class="col-md-3 mb-3">
<label class="form-label">Última Regla</label>
<input type="date" name="ginecoobstetricos[Ultima_Regla]" class="form-control">
</div>
<div class="col-md-3 mb-3">
<label class="form-label">Inicio Vida Sexual</label>
<input type="number" name="ginecoobstetricos[Inicio_Vida_Sexual]" class="form-control">
</div>
@foreach(['Gestaciones','Partos','Abortos','Cesareas'] as $campo)
<div class="col-md-3 mb-3">
<label class="form-label">{{ $campo }}</label>
<input type="number" name="ginecoobstetricos[{{ $campo }}]" class="form-control" value="0">
</div>
@endforeach
</div>
</div>

<!-- Nota Médica -->
<div class="card">
    <div class="card-header">Nota Médica</div>
    <div class="card-body row">
        <div class="col-md-3 mb-3">
            <label class="form-label">Peso (kg)</label>
            <input type="number" step="0.1" name="nota_medica[Peso]" class="form-control">
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Talla (cm)</label>
            <input type="number" step="0.1" name="nota_medica[Talla]" class="form-control">
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Presión Arterial</label>
            <input type="text" name="nota_medica[Presion_Arterial]" class="form-control">
        </div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Frecuencia Cardíaca</label>
            <input type="number" name="nota_medica[Frecuencia_Cardiaca]" class="form-control">
        </div>

        <div class="col-md-12 mb-3">
            <label for="Exploracion_Fisica" class="form-label">Exploración Física</label>
            <textarea id="Exploracion_Fisica" name="nota_medica[Exploracion_Fisica]" class="form-control" rows="3">{{ old('nota_medica.Exploracion_Fisica') }}</textarea>
        </div>

        <div class="col-md-12 mb-3">
            <label class="form-label">Diagnóstico</label>
            <textarea name="nota_medica[Diagnostico]" class="form-control" rows="3">{{ old('nota_medica.Diagnostico') }}</textarea>
        </div>
        
        <div class="col-md-12 mb-3">
            <label class="form-label">Tratamiento</label>
            <textarea name="nota_medica[Tratamiento]" class="form-control" rows="3">{{ old('nota_medica.Tratamiento') }}</textarea>
        </div>
        <div class="col-md-6 mb-3">
            <label class="form-label">Plan a Seguir</label>
            <textarea name="nota_medica[Plan_A_Seguir]" class="form-control" rows="3">{{ old('nota_medica.Plan_A_Seguir') }}</textarea>
        </div>
    </div>
</div>


<!-- Botones Guardar y Volver -->
<div class="d-flex justify-content-between mt-3">
    <a href="{{ route('historia.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left"></i> Volver
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-save"></i> Registrar Historia Clínica
    </button>
</div>

</form>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('buscar_paciente');
    const lista = document.getElementById('resultados');
    const hidden = document.getElementById('Expediente_Id');

    input.addEventListener('input', async function() {
        const q = this.value.trim();
        if (q.length < 2) { lista.style.display = 'none'; return; }

        try {
            const res = await fetch(`/expedientes/buscar-expedientes?q=${encodeURIComponent(q)}`);
            const data = await res.json();
            lista.innerHTML = '';
            if(data.length>0){
                data.forEach(e=>{
                    const nombre = `${e.Nombre} ${e.Apellido}`.trim();
                    const item = document.createElement('a');
                    item.href = '#';
                    item.classList.add('list-group-item','list-group-item-action');
                    item.textContent = `${nombre} — Expediente #${e.Id_Expediente}`;
                    item.addEventListener('click', async ev=>{
                        ev.preventDefault();
                        input.value = nombre;
                        lista.style.display = 'none';
                        hidden.value = e.Id_Expediente;
                        const check = await fetch(`/verificar-historia/${e.Id_Expediente}`);
                        const {existe} = await check.json();
                        if(existe){
                            Swal.fire({
                                icon:'error', 
                                title:'Ya existe una historia clínica', 
                                text:`El expediente #${e.Id_Expediente} ya tiene una historia registrada.`
                            });
                            input.value=''; hidden.value='';
                        }
                    });
                    lista.appendChild(item);
                });
                lista.style.display='block';
            } else {
                lista.innerHTML='<div class="list-group-item text-muted">No se encontraron resultados</div>';
                lista.style.display='block';
            }
        } catch(err){ console.error(err); lista.style.display='none'; }
    });

    document.addEventListener('click', e=>{ if(!lista.contains(e.target) && e.target!==input) lista.style.display='none'; });

    document.getElementById('formHistoria').addEventListener('submit', function(ev){
        if(!hidden.value){
            ev.preventDefault();
            Swal.fire({
                icon:'error', 
                title:'Selecciona un paciente', 
                text:'Debes elegir un expediente antes de registrar la historia clínica.'
            });
        }
    });
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
