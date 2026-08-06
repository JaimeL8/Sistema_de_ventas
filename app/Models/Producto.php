<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
   protected $table = 'productos';
    protected $primaryKey = 'upc'; 
    public $incrementing = false;  
    protected $keyType = 'string'; 

    protected $fillable = [
        'upc', 
        'descripcion', 
        'costo', 
        'precio', 
        'existencia'
    ];
}