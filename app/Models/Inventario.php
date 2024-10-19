<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Inventario extends Model
{
    use HasFactory;

    protected $table = 'inventarios';
    protected $primaryKey = 'id_inventario';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'id_medicamento',
        'id_farmacia',
        'numero_lote',
        'cantidad_disponible',
        'fecha_vencimiento',
    ];

    // Relación con los medicamentos
    public function medicamento()
    {
        return $this->belongsTo(Medicamento::class, 'id_medicamento');
    }

    // Relación con las farmacias
    public function farmacia()
    {
        return $this->belongsTo(Farmacia::class, 'id_farmacia');
    }
}
