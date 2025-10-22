<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
   protected $table = 'paciente';
    protected $primaryKey = 'Id_Paciente';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Apellido',
        'Sexo',
        'Fecha_Nacimiento',
        'Lugar_Origen',
        'Telefono',
        'Contacto_Emergencia'
    ];

    public function expedientes()
    {
        return $this->hasMany(Expediente::class, 'Paciente_Id');
    }
}
