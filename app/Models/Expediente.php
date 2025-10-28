<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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

    protected static function boot()
    {
        parent::boot();

        // Antes de crear un expediente
        static::creating(function ($expediente) {
            $expediente->Fecha_Apertura = Carbon::now(); // Fecha y hora actual
            $expediente->Estado_Expediente = 'Activo';  // Estado fijo
        });
    }

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