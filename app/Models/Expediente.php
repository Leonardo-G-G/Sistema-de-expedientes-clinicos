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

        static::creating(function ($expediente) {
            $expediente->Fecha_Apertura = Carbon::now();
            $expediente->Estado_Expediente = $expediente->Estado_Expediente ?? 'Activo';
        });
    }

    // 🔹 Un expediente pertenece a un paciente
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'Paciente_Id', 'Id_Paciente');
    }

    // 🔹 Un expediente pertenece a un médico
    public function medico()
    {
        return $this->belongsTo(Usuario::class, 'Medico_Id', 'Id_Usuario');
    }

    // 🔹 Un expediente tiene una o varias historias clínicas
    public function historiasClinicas()
    {
        return $this->hasMany(HistoriaClinica::class, 'Expediente_Id', 'Id_Expediente');
    }
}
