<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'precio',
        'descripcion',
        'duracion',
        'condiciones',
        'imagen',
        'activo',
        'destacado',
        'categoria_id',
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
