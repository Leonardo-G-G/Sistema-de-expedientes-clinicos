<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntecedenteHeredofamiliar extends Model
{
    protected $table = 'antecedentes_heredofamiliares';
    protected $primaryKey = 'Id_Antecedente_Heredo';
    public $timestamps = false;

    protected $fillable = [
        'Historia_Id',
        'Diabetes',
        'Hipertension',
        'Cancer',
        'Trastornos_Mentales',
        'Enfermedades_Cronicas',
        'Otros',
    ];

    public function historia()
    {
        return $this->belongsTo(HistoriaClinica::class, 'Historia_Id', 'Id_Historia');
    }
}
