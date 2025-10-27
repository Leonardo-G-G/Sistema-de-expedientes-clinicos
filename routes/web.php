<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExpedienteController;
use App\Http\Controllers\HistoriaClinicaController;
use App\Http\Controllers\PacienteController;
use App\Http\Controllers\NotaMedicaController;

// 🔐 Registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// 🔐 Login / Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// 🚀 Rutas protegidas por autenticación
Route::middleware(['auth'])->group(function () {

    // 🧭 Dashboard general (controlador dedicado)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // 📂 Expedientes Clínicos
    Route::get('/expedientes/crear', [ExpedienteController::class, 'create'])->name('expedientes.create');
    Route::post('/expedientes', [ExpedienteController::class, 'store'])->name('expedientes.store');

    // 🩺 Historia Clínica
    Route::get('/historia/crear', [HistoriaClinicaController::class, 'create'])->name('historia.create');
    Route::post('/historia', [HistoriaClinicaController::class, 'store'])->name('historia.store');

    // 🧾 Nota Médica
    Route::get('/notas/crear', [NotaMedicaController::class, 'create'])->name('notas.create');
    Route::post('/notas', [NotaMedicaController::class, 'store'])->name('notas.store');

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
