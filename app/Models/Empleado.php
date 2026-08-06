<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleado extends Model
{
    use HasFactory;

    // Campos permitidos para asignación masiva
    protected $fillable = ['nombre', 'apellido', 'telefono'];
}
