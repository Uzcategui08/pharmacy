<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class Farmacia extends Model
{
    protected $primaryKey = 'id_farmacia';
    protected $fillable = ['nombre_razon_social', 'rif', 'ubicacion','imagen'];

    //Relación con los usuarios para validar la farmacia
    public function administradores()
    {
        return $this->belongsToMany(User::class, 'farmacia_usuario', 'farmacia_id', 'usuario_id');
    }

    //Relación con los medicamentos
    public function medicamentos()
    {
        return $this->hasMany(Medicamento::class, 'id_farmacia');
    }


}
