<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Producto;

class ProductoController extends Controller
{
    // CONSULTAS (Read)
    public function index()
    {
        $productos = Producto::all();
        return view('productos.index', compact('productos'));
    }

    // ALTAS (Create)
    public function store(Request $request)
    {
        $request->validate([
            'upc' => 'required|unique:productos',
            'descripcion' => 'required',
            'costo' => 'required|numeric',
            'precio' => 'required|numeric',
            'existencia' => 'required|integer'
        ]);

        Producto::create($request->all());
        return back()->with('success', 'Producto creado exitosamente.');
    }

    // CAMBIOS (Update)
    public function update(Request $request, $upc)
    {
        $producto = Producto::findOrFail($upc);
        $producto->update($request->except(['_token', '_method']));
        return back()->with('success', 'Producto actualizado exitosamente.');
    }

    // BAJAS (Delete)
    public function destroy($upc)
    {
        Producto::destroy($upc);
        return back()->with('success', 'Producto eliminado exitosamente.');
    }
}