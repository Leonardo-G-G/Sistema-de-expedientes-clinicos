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
        'Cedula_Profesional',
        'Especialidad',
        'Fecha_Registro',
    ];

    protected $hidden = ['Contraseña'];

    public function expedientes()
    {
        return $this->hasMany(Expediente::class, 'Medico_Id', 'Id_Usuario');
    }

    public function getAuthPassword()
    {
        return $this->Contraseña;
    }

   
    public function getNameAttribute()
    {
        return $this->Nombre . ' ' . $this->Apellido;
    }
}
