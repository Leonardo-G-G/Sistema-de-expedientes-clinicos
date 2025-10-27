<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Historia Clínica</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        :root { --primary: #0d6efd; --bg: #f5f7fa; --sidebar-width: 250px; }
        body { display: flex; margin: 0; min-height: 100vh; font-family: 'Segoe UI', sans-serif; background-color: var(--bg); }
        .sidebar { width: var(--sidebar-width); background: linear-gradient(180deg, #0d6efd, #003c99); color: white; display: flex; flex-direction: column; position: fixed; height: 100%; }
        .sidebar h2 { text-align: center; padding: 1rem 0; border-bottom: 1px solid rgba(255,255,255,0.2); }
        .user-info { text-align: center; padding: 1rem; border-bottom: 1px solid rgba(255,255,255,0.2); }
        .sidebar a { color: white; text-decoration: none; display: flex; align-items: center; gap: 10px; padding: 0.8rem 1.5rem; font-weight: 500; }
        .sidebar a.active, .sidebar a:hover { background-color: rgba(255,255,255,0.15); }
        .main-content { margin-left: var(--sidebar-width); padding: 2rem; flex: 1; }
        header h1 { margin-bottom: 2rem; }
        .card { border-radius: 12px; margin-bottom: 1.5rem; box-shadow: 0 2px 6px rgba(0,0,0,0.1); }
        .card-header { background-color: var(--primary); color: white; font-weight: 600; }
    </style>
</head>
<body>

<aside class="sidebar">
    <h2>Sistema Clínico</h2>
    <div class="user-info">
        <i class="bi bi-person-circle fs-2"></i>
        <p>{{ Auth::user()->name ?? 'Admin' }}</p>
    </div>
    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <i class="bi bi-speedometer2"></i> <span>Dashboard</span>
    </a>
    <a href="{{ route('expedientes.index') }}" class="{{ request()->routeIs('expedientes.*') ? 'active' : '' }}">
        <i class="bi bi-folder-plus"></i> <span>Expedientes</span>
    </a>
    <a href="{{ route('historia.index') }}" class="{{ request()->routeIs('historia.*') ? 'active' : '' }}">
        <i class="bi bi-file-earmark-medical"></i> <span>Historia Clínica</span>
    </a>
    <a href="{{ route('pacientes.index') }}" class="{{ request()->routeIs('pacientes.*') ? 'active' : '' }}">
        <i class="bi bi-person-lines-fill"></i> <span>Pacientes</span>
    </a>
    <a href="{{ route('notas.index') }}" class="{{ request()->routeIs('notas.*') ? 'active' : '' }}">
        <i class="bi bi-journal-medical"></i> <span>Nota Médica</span>
    </a>
    <a href="{{ route('usuario.perfil') }}" class="{{ request()->routeIs('usuario.*') ? 'active' : '' }}">
        <i class="bi bi-person-circle"></i> <span>Perfil</span>
    </a>
    <form action="{{ route('logout') }}" method="POST" class="mt-auto text-center">
        @csrf
        <button type="submit" class="btn btn-danger mt-3"><i class="bi bi-box-arrow-right"></i> Cerrar sesión</button>
    </form>
</aside>    

<div class="main-content">
    <header>
        <h1>Editar Historia Clínica</h1>
    </header>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('historia.update', $historia->Id_Historia) }}" method="POST">
        @csrf
        @method('PUT')

        <!-- Datos generales -->
        <div class="card">
            <div class="card-header">Datos Generales</div>
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label">Expediente</label>
                    <input type="text" class="form-control" 
                        value="Expediente #{{ $historia->expediente->Id_Expediente }} - {{ $historia->expediente->paciente->Nombre }} {{ $historia->expediente->paciente->Apellido }}" disabled>
                    <input type="hidden" name="Expediente_Id" value="{{ $historia->Expediente_Id }}">
                </div>
                
                <div class="mb-3">
                    <label class="form-label">Exploración Física</label>
                    <textarea name="Exploracion_Fisica" class="form-control" rows="3">{{ old('Exploracion_Fisica', $historia->Exploracion_Fisica) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Antecedentes heredofamiliares -->
        <div class="card">
            <div class="card-header">Antecedentes Heredofamiliares</div>
            <div class="card-body row">
                @php $h = $historia->heredofamiliares->first() ?? new \App\Models\AntecedenteHeredofamiliar(); @endphp
                @foreach(['Diabetes','Hipertension','Cancer'] as $campo)
                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ $campo }}</label>
                        <select name="heredofamiliares[{{ $campo }}]" class="form-select">
                            <option value="0" {{ old('heredofamiliares.'.$campo, $h->$campo ?? 0) == 0 ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('heredofamiliares.'.$campo, $h->$campo ?? 0) == 1 ? 'selected' : '' }}>Sí</option>
                        </select>
                    </div>
                @endforeach
                <div class="col-md-12 mb-3">
                    <label class="form-label">Enfermedades Crónicas</label>
                    <input type="text" name="heredofamiliares[Enfermedades_Cronicas]" class="form-control"
                        value="{{ old('heredofamiliares.Enfermedades_Cronicas', $h->Enfermedades_Cronicas ?? '') }}">
                </div>
                <div class="col-md-12 mb-3">
                    <label class="form-label">Otros</label>
                    <input type="text" name="heredofamiliares[Otros]" class="form-control"
                        value="{{ old('heredofamiliares.Otros', $h->Otros ?? '') }}">
                </div>
            </div>
        </div>

        <!-- Antecedentes no patológicos -->
        <div class="card">
            <div class="card-header">Antecedentes No Patológicos</div>
            <div class="card-body row">
                @php $np = $historia->noPatologicos->first() ?? new \App\Models\AntecedenteNoPatologico(); @endphp
                @foreach(['Tipo_Vivienda','Religion','Alimentacion','Actividad_Fisica'] as $campo)
                    <div class="col-md-6 mb-3">
                        <label class="form-label">{{ str_replace('_', ' ', $campo) }}</label>
                        <input type="text" name="no_patologicos[{{ $campo }}]" class="form-control"
                            value="{{ old('no_patologicos.'.$campo, $np->$campo ?? '') }}">
                    </div>
                @endforeach
                @foreach(['Tabaquismo','Alcoholismo','Drogas'] as $campo)
                    <div class="col-md-4 mb-3">
                        <label class="form-label">{{ $campo }}</label>
                        <select name="no_patologicos[{{ $campo }}]" class="form-select">
                            <option value="0" {{ old('no_patologicos.'.$campo, $np->$campo ?? 0) == 0 ? 'selected' : '' }}>No</option>
                            <option value="1" {{ old('no_patologicos.'.$campo, $np->$campo ?? 0) == 1 ? 'selected' : '' }}>Sí</option>
                        </select>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Antecedentes patológicos -->
        <div class="card">
            <div class="card-header">Antecedentes Patológicos</div>
            <div class="card-body">
                @php $p = $historia->patologicos->first() ?? new \App\Models\AntecedentePatologico(); @endphp
                <label class="form-label">Descripción</label>
                <textarea name="patologicos[Descripcion]" class="form-control" rows="2">{{ old('patologicos.Descripcion', $p->Descripcion ?? '') }}</textarea>
            </div>
        </div>

        <!-- Antecedentes ginecoobstétricos -->
        <div class="card">
            <div class="card-header">Antecedentes Ginecoobstétricos</div>
            <div class="card-body row">
                @php $g = $historia->ginecoobstetricos->first() ?? new \App\Models\AntecedenteGinecoobstetrico(); @endphp
                <div class="col-md-4 mb-3">
                    <label class="form-label">Menarca (edad)</label>
                    <input type="number" name="ginecoobstetricos[Menarca_Edad]" class="form-control"
                        value="{{ old('ginecoobstetricos.Menarca_Edad', $g->Menarca_Edad ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Tipo de Ciclo</label>
                    <input type="text" name="ginecoobstetricos[Tipo_Ciclo]" class="form-control"
                        value="{{ old('ginecoobstetricos.Tipo_Ciclo', $g->Tipo_Ciclo ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Ciclos Regulares</label>
                    <select name="ginecoobstetricos[Ciclos_Regulares]" class="form-select">
                        <option value="1" {{ old('ginecoobstetricos.Ciclos_Regulares', $g->Ciclos_Regulares ?? 0) == 1 ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ old('ginecoobstetricos.Ciclos_Regulares', $g->Ciclos_Regulares ?? 0) == 0 ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Ciclos Dolorosos</label>
                    <select name="ginecoobstetricos[Ciclos_Dolor]" class="form-select">
                        <option value="1" {{ old('ginecoobstetricos.Ciclos_Dolor', $g->Ciclos_Dolor ?? 0) == 1 ? 'selected' : '' }}>Sí</option>
                        <option value="0" {{ old('ginecoobstetricos.Ciclos_Dolor', $g->Ciclos_Dolor ?? 0) == 0 ? 'selected' : '' }}>No</option>
                    </select>
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Última Regla</label>
                    <input type="date" name="ginecoobstetricos[Ultima_Regla]" class="form-control"
                        value="{{ old('ginecoobstetricos.Ultima_Regla', $g->Ultima_Regla ?? '') }}">
                </div>
                <div class="col-md-4 mb-3">
                    <label class="form-label">Inicio Vida Sexual (edad)</label>
                    <input type="number" name="ginecoobstetricos[Inicio_Vida_Sexual]" class="form-control"
                        value="{{ old('ginecoobstetricos.Inicio_Vida_Sexual', $g->Inicio_Vida_Sexual ?? '') }}">
                </div>
                @foreach(['Gestaciones','Partos','Abortos','Cesareas'] as $campo)
                    <div class="col-md-3 mb-3">
                        <label class="form-label">{{ $campo }}</label>
                        <input type="number" min="0" name="ginecoobstetricos[{{ $campo }}]" class="form-control"
                            value="{{ old('ginecoobstetricos.'.$campo, $g->$campo ?? 0) }}">
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Nota médica -->
        <div class="card">
            <div class="card-header">Nota Médica</div>
            <div class="card-body row">
                @php $n = $historia->expediente->notaMedicas->first() ?? new \App\Models\NotaMedica(); @endphp
                <div class="col-md-3 mb-3">
                    <label class="form-label">Peso (kg)</label>
                    <input type="number" step="0.1" name="nota_medica[Peso]" class="form-control"
                        value="{{ old('nota_medica.Peso', $n->Peso ?? '') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Talla (cm)</label>
                    <input type="number" step="0.1" name="nota_medica[Talla]" class="form-control"
                        value="{{ old('nota_medica.Talla', $n->Talla ?? '') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Presión Arterial</label>
                    <input type="text" name="nota_medica[Presion_Arterial]" class="form-control"
                        value="{{ old('nota_medica.Presion_Arterial', $n->Presion_Arterial ?? '') }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Frecuencia Cardíaca</label>
                    <input type="number" name="nota_medica[Frecuencia_Cardiaca]" class="form-control"
                        value="{{ old('nota_medica.Frecuencia_Cardiaca', $n->Frecuencia_Cardiaca ?? '') }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Impresión Diagnóstica</label>
                    <textarea name="nota_medica[Impresion_Diagnostica]" class="form-control">{{ old('nota_medica.Impresion_Diagnostica', $n->Impresion_Diagnostica ?? '') }}</textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Tratamiento</label>
                    <textarea name="nota_medica[Tratamiento]" class="form-control">{{ old('nota_medica.Tratamiento', $n->Tratamiento ?? '') }}</textarea>
                </div>

                <!-- NUEVO CAMPO: OBSERVACIÓN -->
                <div class="col-md-12 mb-3">
                    <label class="form-label">Observación</label>
                    <textarea name="nota_medica[Observacion]" class="form-control" rows="2">{{ old('nota_medica.Observacion', $n->Observacion ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Padecimiento Actual</label>
                    <textarea name="Padecimiento_Actual" class="form-control" rows="3">{{ old('Padecimiento_Actual', $historia->Padecimiento_Actual) }}</textarea>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-success">Actualizar Historia Clínica</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
