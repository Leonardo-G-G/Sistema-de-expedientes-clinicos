<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntecedentePatologico extends Model
{
    protected $table = 'antecedentes_patologicos';
    protected $primaryKey = 'Id_Antecedente_Patologico';
    public $timestamps = false;

    protected $fillable = [
        'Historia_Id',
        'Cirugias',
        'Alergias',
        'Hospitalizaciones',
        'Enfermedades_Infecciosas',
        'Transfusiones'
    ];

    public function historiaClinica()
    {
        return $this->belongsTo(HistoriaClinica::class, 'Historia_Id');
    }
}
