<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    // Campos permitidos para el alta y cambio
    protected $fillable = [
        'nombre', 
        'apellido', 
        'direccion', 
        'email', 
        'usuario', 
        'fecha_nacimiento'
    ];
}