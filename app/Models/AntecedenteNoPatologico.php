<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntecedenteNoPatologico extends Model
{
    protected $table = 'antecedentes_no_patologicos';
    protected $primaryKey = 'Id_Antecedente_NoPatologico';
    public $timestamps = false;

    protected $fillable = [
        'Historia_Id',
        'Tipo_Vivienda',
        'Religion',
        'Alimentacion',
        'Actividad_Fisica',
        'Tabaquismo',
        'Alcoholismo',
        'Drogas',
    ];

    public function historia()
    {
        return $this->belongsTo(HistoriaClinica::class, 'Historia_Id', 'Id_Historia');
    }
}
