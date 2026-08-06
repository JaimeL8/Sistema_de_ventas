<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = ['id_empleado', 'id_cliente', 'total', 'estatus'];

    // Relación con Cliente
    public function cliente() {
        return $this->belongsTo(Cliente::class, 'id_cliente');
    }

    // Relación con Empleado
    public function empleado() {
        return $this->belongsTo(Empleado::class, 'id_empleado');
    }

    // Relación con los Detalles (Productos agregados)
    public function detalles() {
        return $this->hasMany(VentaDetalle::class, 'id_venta');
    }
}