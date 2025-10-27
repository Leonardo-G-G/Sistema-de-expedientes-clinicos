<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expediente extends Model
{
    protected $table = 'expediente';
    protected $primaryKey = 'Id_Expediente';
    public $timestamps = false;

    protected $fillable = [
        'Paciente_Id',
        'Medico_Id',
        'Fecha_Apertura',
        'Estado_Expediente',
    ];

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'Paciente_Id', 'Id_Paciente');
    }

    public function medico()
    {
        return $this->belongsTo(Usuario::class, 'Medico_Id', 'Id_Usuario');
    }

    public function historiaClinica()
    {
        return $this->hasOne(HistoriaClinica::class, 'Expediente_Id', 'Id_Expediente');
    }

    public function notaMedicas()
    {
        return $this->hasMany(NotaMedica::class, 'Expediente_Id', 'Id_Expediente');
    }
}
