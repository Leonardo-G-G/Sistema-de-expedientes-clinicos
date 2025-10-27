<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaMedica extends Model
{
    protected $table = 'nota_medica';
    protected $primaryKey = 'Id_Nota';
    public $timestamps = false;

    protected $fillable = [
        'Expediente_Id',
        'Fecha',
        'Hora',
        'Impresion_Diagnostica',
        'Tratamiento',
        'Observacion',
        'Peso',
        'Talla',
        'Presion_Arterial',
        'Frecuencia_Cardiaca',
    ];

    public function expediente()
    {
        return $this->belongsTo(Expediente::class, 'Expediente_Id', 'Id_Expediente');
    }
}
