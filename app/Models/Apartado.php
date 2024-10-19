<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Apartado extends Model
{
    use HasFactory;

    protected $table = 'apartados';

    protected $fillable = [
        'id_usuario',
        'id_farmacia',
        'estado',
        'fecha',
        'fecha_expiracion'
    ];

    // Relación con los items de los apartados
    public function items()
    {
        return $this->hasMany(ApartadoItem::class, 'id_apartado');
    }

    // Relación con los usuarios
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    // Relación con las farmacias
    public function farmacia()
    {
        return $this->belongsTo(Farmacia::class, 'id_farmacia');
    }

    public function detalles()
    {
        return $this->hasMany(ApartadoItem::class, 'id_apartado');
    }
}
