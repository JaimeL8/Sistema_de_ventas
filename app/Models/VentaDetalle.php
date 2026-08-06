<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VentaDetalle extends Model
{
    protected $fillable = ['id_venta', 'id_producto', 'precio', 'cantidad', 'utilidad'];

    // Relación con Producto
    public function producto() {
        return $this->belongsTo(Producto::class, 'id_producto', 'upc');
    }
}