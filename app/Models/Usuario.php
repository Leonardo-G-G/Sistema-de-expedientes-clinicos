<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use Notifiable;

    protected $table = 'usuario';
    protected $primaryKey = 'Id_Usuario';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Apellido',
        'Correo_Electronico',
        'Contraseña',
        'Rol_Id',
        'Cedula_Profesional',
        'Especialidad'
    ];

    protected $hidden = ['Contraseña', 'remember_token'];

    public function getAuthPassword()
    {
        return $this->Contraseña;
    }
}
