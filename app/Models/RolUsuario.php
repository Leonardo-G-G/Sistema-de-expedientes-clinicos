<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RolUsuario extends Model
{
    protected $table = 'rol_usuario';
    protected $primaryKey = 'Id_Rol';
    public $timestamps = false;

    protected $fillable = [
        'Nombre',
        'Descripcion'
    ];

    public function usuarios()
    {
        return $this->hasMany(Usuario::class, 'Rol_Id');
    }
}
