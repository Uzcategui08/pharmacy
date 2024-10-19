<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    use HasFactory;

    protected $table = 'medicamentos';
    protected $primaryKey = 'id_medicamento';
    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nombre',
        'precio',
        'fabricante',
        'descripcion',
        'pais_fabricacion',
        'categoria',
        'id_farmacia',
        'Foto'
    ];

    //Relación con las farmacias
    public function farmacia()
    {
        return $this->belongsTo(Farmacia::class, 'id_farmacia');
    }

    //Relación con los apartados
    public function apartados()
    {
        return $this->hasMany(Apartado::class, 'id_medicamento');
    }

    //Relación con la lista 
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class, 'id_medicamento', 'id_medicamento');
    }
}
