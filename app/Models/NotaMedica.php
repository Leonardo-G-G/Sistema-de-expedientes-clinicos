<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotaMedica extends Model
{
    protected $table = 'nota_medica';
    protected $primaryKey = 'Id_Nota';
    public $timestamps = false;

    protected $fillable = [
        'Historia_Id', 'Fecha', 'Hora', 'Peso', 'Talla',
        'Presion_Arterial', 'Frecuencia_Cardiaca',
        'Impresion_Diagnostica', 'Tratamiento', 'Observacion'
    ];

    // Relación con Historia Clínica
    public function historiaClinica()
    {
        return $this->belongsTo(HistoriaClinica::class, 'Historia_Id', 'Id_Historia');
    }
}
