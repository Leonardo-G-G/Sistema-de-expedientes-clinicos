<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\AntecedenteGinecoobstetrico;
use App\Models\AntecedenteHeredofamiliar;
use App\Models\AntecedenteNoPatologico;
use App\Models\AntecedentePatologico;

class HistoriaClinica extends Model
{
    protected $table = 'historia_clinica';
    protected $primaryKey = 'Id_Historia';
    public $timestamps = false;

    protected $fillable = [
        'Expediente_Id',
        'Padecimiento_Actual',
        'Exploracion_Fisica',
    ];

    // Relación con expediente
    public function expediente()
    {
        return $this->belongsTo(Expediente::class, 'Expediente_Id', 'Id_Expediente');
    }

    // ✅ Cada historia tiene un solo conjunto de antecedentes, no varios
    public function ginecoobstetricos()
    {
        return $this->hasOne(AntecedenteGinecoobstetrico::class, 'Historia_Id', 'Id_Historia');
    }

    public function heredofamiliares()
    {
        return $this->hasOne(AntecedenteHeredofamiliar::class, 'Historia_Id', 'Id_Historia');
    }

    public function noPatologicos()
    {
        return $this->hasOne(AntecedenteNoPatologico::class, 'Historia_Id', 'Id_Historia');
    }

    public function patologicos()
    {
        return $this->hasOne(AntecedentePatologico::class, 'Historia_Id', 'Id_Historia');
    }
}
