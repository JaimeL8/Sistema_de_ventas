<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empleado;

class EmpleadoController extends Controller
{
    // CONSULTAS (Read)
    public function index()
    {

        $empleados = Empleado::orderBy('id', 'desc')->get();
        return view('empleados.index', compact('empleados'));
    }

    // ALTAS (Create)
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:45',
            'apellido' => 'required|max:45',
            'telefono' => 'nullable|max:20'
        ]);

        Empleado::create($request->all());
        return back()->with('success', 'Empleado registrado exitosamente.');
    }

    // CAMBIOS (Update)
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|max:45',
            'apellido' => 'required|max:45',
            'telefono' => 'nullable|max:20'
        ]);

        $empleado = Empleado::findOrFail($id);
        $empleado->update($request->except(['_token', '_method']));
        
        return back()->with('success', 'Datos del empleado actualizados exitosamente.');
    }

    // BAJAS (Delete)
    public function destroy($id)
    {
        Empleado::destroy($id);
        return back()->with('success', 'Empleado eliminado del sistema.');
    }
}