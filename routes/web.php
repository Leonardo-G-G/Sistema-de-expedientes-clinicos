<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\HistoriaClinicaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\NotaMedicaController;
use App\Http\Controllers\UsuarioController;

// 🔐 Registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// 🔐 Login / Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 🚀 Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // 🧭 Dashboard general
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 📂 Expedientes Clínicos (CRUD completo)
    Route::prefix('expedientes')->name('expedientes.')->group(function () {
        Route::get('/', [ExpedienteController::class, 'index'])->name('index');
        Route::get('/crear', [ExpedienteController::class, 'create'])->name('create');
        Route::post('/', [ExpedienteController::class, 'store'])->name('store');
        Route::get('/{Id_Expediente}/editar', [ExpedienteController::class, 'edit'])->name('edit');
        Route::put('/{Id_Expediente}', [ExpedienteController::class, 'update'])->name('update');
        Route::delete('/{Id_Expediente}', [ExpedienteController::class, 'destroy'])->name('destroy');
    });

    // 🩺 Historia Clínica (CRUD completo)
    Route::prefix('historia')->name('historia.')->group(function () {
    Route::get('/', [HistoriaClinicaController::class, 'index'])->name('index');
    Route::get('/crear', [HistoriaClinicaController::class, 'create'])->name('create');
    Route::post('/', [HistoriaClinicaController::class, 'store'])->name('store');
    Route::get('/{Id_Historia}', [HistoriaClinicaController::class, 'show'])->name('show'); // 👈 Agregada
    Route::get('/{Id_Historia}/editar', [HistoriaClinicaController::class, 'edit'])->name('edit');
    Route::put('/{Id_Historia}', [HistoriaClinicaController::class, 'update'])->name('update');
    Route::delete('/{Id_Historia}', [HistoriaClinicaController::class, 'destroy'])->name('destroy');
});

    // 🧾 Nota Médica
    Route::prefix('notas')->name('notas.')->group(function () {
    Route::get('/', [NotaMedicaController::class, 'index'])->name('index');           // Listado
    Route::get('/crear', [NotaMedicaController::class, 'create'])->name('create');    // Formulario crear
    Route::post('/', [NotaMedicaController::class, 'store'])->name('store');          // Guardar
    Route::get('/{Id_Nota}/editar', [NotaMedicaController::class, 'edit'])->name('edit');   // Editar
    Route::put('/{Id_Nota}', [NotaMedicaController::class, 'update'])->name('update');      // Actualizar
    Route::delete('/{Id_Nota}', [NotaMedicaController::class, 'destroy'])->name('destroy'); // Eliminar
    Route::get('/{Id_Nota}', [NotaMedicaController::class, 'show'])->name('show');         // Ver detalle
});


    // 👤 Perfil de usuario
    Route::prefix('perfil')->name('usuario.')->group(function () {
        Route::get('/', [UsuarioController::class, 'index'])->name('perfil');
        Route::get('/editar', [UsuarioController::class, 'edit'])->name('editar');
        Route::put('/', [UsuarioController::class, 'update'])->name('actualizar');
    });

    // 👨‍⚕️ CRUD de Pacientes
    Route::prefix('pacientes')->name('pacientes.')->group(function () {
        Route::get('/', [PacienteController::class, 'index'])->name('index');
        Route::get('/crear', [PacienteController::class, 'create'])->name('create');
        Route::post('/', [PacienteController::class, 'store'])->name('store');
        Route::get('/{Id_Paciente}/editar', [PacienteController::class, 'edit'])->name('edit');
        Route::put('/{Id_Paciente}', [PacienteController::class, 'update'])->name('update');
        Route::delete('/{Id_Paciente}', [PacienteController::class, 'destroy'])->name('destroy');
    });
});

// 🔄 Redirección por defecto al login
Route::get('/', function () {
    return redirect()->route('login');
});
