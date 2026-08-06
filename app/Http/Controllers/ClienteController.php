<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use Illuminate\Validation\Rule; 

class ClienteController extends Controller
{
    // CONSULTAS (Read)
    public function index()
    {
        $clientes = Cliente::orderBy('id', 'desc')->get();
        return view('clientes.index', compact('clientes'));
    }

    // ALTAS (Create)
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:45',
            'apellido' => 'required|max:45',
            'direccion' => 'nullable|max:100',
            // El email y usuario deben ser únicos en la tabla clientes
            'email' => 'nullable|email|max:45|unique:clientes,email',
            'usuario' => 'nullable|max:45|unique:clientes,usuario',
            'fecha_nacimiento' => 'nullable|date'
        ]);

        Cliente::create($request->all());
        return back()->with('success', 'Cliente registrado exitosamente.');
    }

    // CAMBIOS (Update)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:45',
            'apellido' => 'required|max:45',
            'direccion' => 'nullable|max:100',
            // se validan únicos, pero ignoramos el ID del cliente actual
            'email' => ['nullable', 'email', 'max:45', Rule::unique('clientes')->ignore($id)],
            'usuario' => ['nullable', 'max:45', Rule::unique('clientes')->ignore($id)],
            'fecha_nacimiento' => 'nullable|date'
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($request->except(['_token', '_method']));
        
        return back()->with('success', 'Datos del cliente actualizados exitosamente.');
    }

    // BAJAS (Delete)
    public function destroy($id)
    {
        Cliente::destroy($id);
        return back()->with('success', 'Cliente eliminado del sistema.');
    }
}