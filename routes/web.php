<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\EmpleadoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [HomeController::class, 'index']);

// Rutas para mostrar las pantallas principales (index) de cada módulo
Route::get('/ventas', [VentaController::class, 'index']);
// Altas y consultas de VENTAS
Route::post('/ventas', [VentaController::class, 'store']); // Para crear la venta inicial
Route::get('/ventas/{id}', [VentaController::class, 'show']); // Para ver el detalle/carrito

Route::get('/productos', [ProductoController::class, 'index']);
Route::get('/clientes', [ClienteController::class, 'index']);
Route::get('/empleados', [EmpleadoController::class, 'index']);

// Rutas de acciones de ventas que hicimos anteriormente
Route::post('/ventas/{id}/cobrar', [VentaController::class, 'cobrar']);
Route::post('/ventas/{id}/cancelar', [VentaController::class, 'cancelar']);
Route::post('/ventas/{id}/agregar-producto', [VentaController::class, 'agregarProducto']);
Route::delete('/ventas/detalle/{id}', [VentaController::class, 'eliminarProducto']);


// Nuevas rutas para Altas, Cambios y Bajas de PRODUCTOS
Route::post('/productos', [ProductoController::class, 'store']); // Guardar nuevo
Route::put('/productos/{upc}', [ProductoController::class, 'update']); // Actualizar
Route::delete('/productos/{upc}', [ProductoController::class, 'destroy']); // Eliminar

// Nuevas rutas para Altas, Cambios y Bajas de EMPLEADOS
Route::post('/empleados', [App\Http\Controllers\EmpleadoController::class, 'store']);
Route::put('/empleados/{id}', [App\Http\Controllers\EmpleadoController::class, 'update']);
Route::delete('/empleados/{id}', [App\Http\Controllers\EmpleadoController::class, 'destroy']);

// Nuevas rutas para Altas, Cambios y Bajas de CLIENTES
Route::post('/clientes', [App\Http\Controllers\ClienteController::class, 'store']);
Route::put('/clientes/{id}', [App\Http\Controllers\ClienteController::class, 'update']);
Route::delete('/clientes/{id}', [App\Http\Controllers\ClienteController::class, 'destroy']);