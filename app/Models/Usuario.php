<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;

class Usuario extends Authenticatable
{
    use Notifiable;

    // Tabla y clave primaria
    protected $table = 'usuario';
    protected $primaryKey = 'Id_Usuario';
    public $timestamps = false;

    // Campos permitidos para asignación masiva
    protected $fillable = [
        'Nombre',
        'Apellido',
        'email',
        'password',
        'Cedula_Profesional',
        'Especialidad',
        'Fecha_Registro',
    ];

    // Campos ocultos para arrays y JSON
    protected $hidden = [
        'password',
    ];

    /**
     * Sobrescribe la notificación de restablecimiento de contraseña
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Accesor para obtener el nombre completo del usuario
     */
    public function getNombreCompletoAttribute()
    {
        return trim("{$this->Nombre} {$this->Apellido}");
    }
}
