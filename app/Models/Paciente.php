<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'Contacto_Emergencia',
    ];

    // Relación con expediente
    public function expediente()
    {
        return $this->hasOne(Expediente::class, 'Paciente_Id', 'Id_Paciente');
    }

    // Calcular edad automáticamente
    public function getEdadAttribute()
    {
        return $this->Fecha_Nacimiento ? Carbon::parse($this->Fecha_Nacimiento)->age : null;
    }
}
