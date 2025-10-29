<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AntecedenteGinecoobstetrico extends Model
{
    protected $table = 'antecedentes_ginecoobstetricos';
    protected $primaryKey = 'Id_Antecedente_Gineco';
    public $timestamps = false;

    protected $fillable = [
        'Historia_Id',
        'Menarca_Edad',
        'Tipo_Ciclo',
        'Ciclos_Dolor',
        'Ultima_Regla',
        'Inicio_Vida_Sexual',
        'Gestaciones',
        'Partos',
        'Abortos',
        'Cesareas',
    ];

    public function historia()
    {
        return $this->belongsTo(HistoriaClinica::class, 'Historia_Id', 'Id_Historia');
    }
}
