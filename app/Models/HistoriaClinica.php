<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function expediente()
    {
        return $this->belongsTo(Expediente::class, 'Expediente_Id', 'Id_Expediente');
    }

    public function antecedentesHeredofamiliares()
    {
        return $this->hasOne(AntecedenteHeredofamiliar::class, 'Historia_Id', 'Id_Historia');
    }

    public function antecedentesPatologicos()
    {
        return $this->hasOne(AntecedentePatologico::class, 'Historia_Id', 'Id_Historia');
    }

    public function antecedentesNoPatologicos()
    {
        return $this->hasOne(AntecedenteNoPatologico::class, 'Historia_Id', 'Id_Historia');
    }

    public function antecedentesGinecoobstetricos()
    {
        return $this->hasOne(AntecedenteGinecoobstetrico::class, 'Historia_Id', 'Id_Historia');
    }
}
