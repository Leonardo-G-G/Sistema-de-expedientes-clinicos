<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotaMedica extends Model
{
    use HasFactory;

    protected $table = 'nota_medica';
    protected $primaryKey = 'Id_Nota';
    public $timestamps = false;

    protected $fillable = [
        'Historia_Id',
        'Fecha',
        'Hora',
        'Peso',
        'Talla',
        'Presion_Arterial',
        'Frecuencia_Cardiaca',
        'Exploracion_Fisica',
        'Diagnostico',
        'Tratamiento',
        'Plan_A_Seguir',
    ];

    // 🔹 Relación inversa
    public function historiaClinica()
    {
        return $this->belongsTo(HistoriaClinica::class, 'Historia_Id', 'Id_Historia');
    }
}
