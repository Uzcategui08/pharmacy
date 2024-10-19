<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApartadoItem extends Model
{
    use HasFactory;

    protected $table = 'apartado_items';

    protected $fillable = [
        'id_apartado',
        'id_medicamento',
        'cantidad',
        'precio',
        'numero_lote'
    ];

    // Relación con apartado
    public function apartado()
    {
        return $this->belongsTo(Apartado::class, 'id_apartado');
    }

    // Relación con medicamento
    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class, 'id_medicamento');
    }
}
