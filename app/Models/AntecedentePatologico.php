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
        'Descripcion',
    ];

    public function historia()
    {
        return $this->belongsTo(HistoriaClinica::class, 'Historia_Id', 'Id_Historia');
    }
}
