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
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;

/*
|--------------------------------------------------------------------------
| 🔐 RUTAS DE AUTENTICACIÓN
|--------------------------------------------------------------------------
*/

// Registro
Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

// Login / Logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

// Rutas de restablecimiento de contraseña (fuera del grupo auth)
Route::get('password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

/*
|--------------------------------------------------------------------------
| 🔒 RUTAS PROTEGIDAS POR AUTENTICACIÓN
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    // 🧭 Dashboard principal
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    /*
    |----------------------------------------------------------------------
    | 📂 Expedientes Clínicos
    |----------------------------------------------------------------------
    */
    Route::prefix('expedientes')->name('expedientes.')->group(function () {
        Route::get('/', [ExpedienteController::class, 'index'])->name('index');
        Route::post('/', [ExpedienteController::class, 'store'])->name('store');
        Route::get('/{Id_Expediente}/editar', [ExpedienteController::class, 'edit'])->name('edit');
        Route::put('/{Id_Expediente}', [ExpedienteController::class, 'update'])->name('update');
        Route::delete('/{Id_Expediente}', [ExpedienteController::class, 'destroy'])->name('destroy');

        Route::get('/buscar-pacientes', [ExpedienteController::class, 'buscarPacientes'])->name('buscarPacientes');
        Route::get('/buscar-expedientes', [ExpedienteController::class, 'buscarExpedientes'])->name('buscarExpedientes');
    });

    Route::get('/buscar-historias', [NotaMedicaController::class, 'buscarHistorias'])->name('buscarHistorias');
    Route::get('/verificar-nota/{Historia_Id}', [NotaMedicaController::class, 'verificarNota'])->name('verificarNota');

    /*
    |----------------------------------------------------------------------
    | 🩺 Historia Clínica
    |----------------------------------------------------------------------
    */
    Route::prefix('historia')->name('historia.')->group(function () {
        Route::get('/', [HistoriaClinicaController::class, 'index'])->name('index');
        Route::get('/crear', [HistoriaClinicaController::class, 'create'])->name('create');
        Route::post('/', [HistoriaClinicaController::class, 'store'])->name('store');
        Route::get('/{id}', [HistoriaClinicaController::class, 'show'])->name('show');
        Route::get('/{id}/editar', [HistoriaClinicaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [HistoriaClinicaController::class, 'update'])->name('update');
        Route::delete('/{id}', [HistoriaClinicaController::class, 'destroy'])->name('destroy');
    });

    /*
    |----------------------------------------------------------------------
    | 🧾 Notas Médicas
    |----------------------------------------------------------------------
    */
    Route::prefix('notas')->name('notas.')->group(function () {
        Route::get('/', [NotaMedicaController::class, 'index'])->name('index');
        Route::get('/crear', [NotaMedicaController::class, 'create'])->name('create');
        Route::post('/', [NotaMedicaController::class, 'store'])->name('store');
        Route::get('/{id}', [NotaMedicaController::class, 'show'])->name('show');
        Route::get('/{id}/editar', [NotaMedicaController::class, 'edit'])->name('edit');
        Route::put('/{id}', [NotaMedicaController::class, 'update'])->name('update');
        Route::delete('/{id}', [NotaMedicaController::class, 'destroy'])->name('destroy');
    });

    /*
    |----------------------------------------------------------------------
    | 👨‍⚕️ Pacientes
    |----------------------------------------------------------------------
    */
    Route::prefix('pacientes')->name('pacientes.')->group(function () {
        Route::get('/', [PacienteController::class, 'index'])->name('index');
        Route::get('/crear', [PacienteController::class, 'create'])->name('create');
        Route::post('/', [PacienteController::class, 'store'])->name('store');
        Route::get('/{Id_Paciente}/editar', [PacienteController::class, 'edit'])->name('edit');
        Route::put('/{Id_Paciente}', [PacienteController::class, 'update'])->name('update');
        Route::delete('/{Id_Paciente}', [PacienteController::class, 'destroy'])->name('destroy');
        Route::get('/{Id_Paciente}', [PacienteController::class, 'show'])->name('show');
    });

    /*
    |----------------------------------------------------------------------
    | 👤 Perfil de Usuario
    |----------------------------------------------------------------------
    */
    Route::prefix('perfil')->name('usuario.')->group(function () {
        Route::get('/', [UsuarioController::class, 'index'])->name('perfil');
        Route::get('/editar', [UsuarioController::class, 'edit'])->name('editar');
        Route::put('/', [UsuarioController::class, 'update'])->name('actualizar');
    });

});

/*
|--------------------------------------------------------------------------
| 🚪 Redirección por defecto
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return redirect()->route('login');
});
