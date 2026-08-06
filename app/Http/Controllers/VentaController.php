<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Models\Producto;
use App\Models\VentaDetalle;
use App\Models\Cliente;
use App\Models\Empleado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Exception;

class VentaController extends Controller
{


    // 1. Mostrar todas las ventas
    public function index()
    {
        // Se traen las ventas con los datos del cliente y empleado asociados
        $ventas = Venta::with(['cliente', 'empleado'])->orderBy('id', 'desc')->get();
        $clientes = Cliente::all();
        $empleados = Empleado::all();
        
        return view('ventas.index', compact('ventas', 'clientes', 'empleados'));
    }

    // 2. Crear una nueva Venta (en blanco, estatus 0)
    public function store(Request $request)
    {
        $request->validate([
            'id_cliente' => 'required|exists:clientes,id',
            'id_empleado' => 'required|exists:empleados,id',
        ]);

        $venta = Venta::create([
            'id_cliente' => $request->id_cliente,
            'id_empleado' => $request->id_empleado,
            'estatus' => 0, // 0 = Abierta
            'total' => 0.00
        ]);

        // Redirigir al detalle de la venta para que empiece a agregar productos
        return redirect('/ventas/' . $venta->id)->with('success', 'Venta creada. Ahora puedes agregar productos.');
    }

    // 3. Ver el detalle de una Venta (El "Carrito")
    public function show($id)
    {
        $venta = Venta::with(['cliente', 'empleado', 'detalles.producto'])->findOrFail($id);
        // Solo se muestran los productos que tengan existencia para agregar 
        $productos = Producto::where('existencia', '>', 0)->get(); 

        return view('ventas.show', compact('venta', 'productos'));
    }




    ### 1. Función para Cobrar Venta
    public function cobrar($id)
    {
        $venta = Venta::findOrFail($id);
        
        // Regla de negocio: Solo se pueden cobrar ventas abiertas (estatus 0)
        if ($venta->estatus != 0) {
            return back()->with('error', 'Solo se pueden cobrar ventas que están abiertas.');
        }

        try {
            DB::transaction(function () use ($venta) {
                // 1. Cambiar estatus a Cobrada
                $venta->estatus = 1; 
                $venta->save();

                // 2. Descontar inventario de cada producto
                $detalles = VentaDetalle::where('id_venta', $venta->id)->get();
                foreach ($detalles as $detalle) {
                    $producto = Producto::where('upc', $detalle->id_producto)->firstOrFail();
                    $producto->existencia -= $detalle->cantidad;
                    $producto->save();
                }
            });

            return back()->with('success', 'Venta cobrada con éxito. Inventario descontado.');
            
        } catch (Exception $e) {
            return back()->with('error', 'Error al procesar el cobro: ' . $e->getMessage());
        }
    }
    
    ### 2. Función para Cancelar Venta
    public function cancelar($id)
    {
        $venta = Venta::findOrFail($id);
        
        // Regla de negocio: Solo se pueden cancelar ventas cobradas (estatus 1)
        if ($venta->estatus != 1) {
            return back()->with('error', 'Solo se pueden cancelar ventas que ya han sido cobradas.');
        }

        try {
            DB::transaction(function () use ($venta) {
                // 1. Cambiar estatus a Cancelada
                $venta->estatus = 2; 
                $venta->save();

                // 2. Regresar el inventario de cada producto sumando la cantidad
                $detalles = VentaDetalle::where('id_venta', $venta->id)->get();
                foreach ($detalles as $detalle) {
                    $producto = Producto::where('upc', $detalle->id_producto)->firstOrFail();
                    $producto->existencia += $detalle->cantidad;
                    $producto->save();
                }
            });

            return back()->with('success', 'Venta cancelada con éxito. El inventario ha sido restaurado.');
            
        } catch (Exception $e) {
            return back()->with('error', 'Error al cancelar la venta: ' . $e->getMessage());
        }
    }

    ### 3. Función para Agregar Producto al Detalle (Ejemplo base)
    public function agregarProducto(Request $request, $id_venta)
    {
        // 1. Validar que la petición traiga los datos necesarios
        $request->validate([
            'id_producto' => 'required|string|exists:productos,upc',
            'cantidad' => 'required|integer|min:1'
        ]);

        $venta = Venta::findOrFail($id_venta);

        // 2. Regla de negocio: No se puede modificar una venta cobrada o cancelada
        if ($venta->estatus != 0) {
            return back()->with('error', 'No se pueden agregar productos. La venta ya fue procesada.');
        }

        // 3. Obtener el producto para sacar su precio y costo actuales
        $producto = Producto::where('upc', $request->id_producto)->firstOrFail();
        
        // 4. Calcular la utilidad de esta partida
        $utilidad_unitaria = $producto->precio - $producto->costo;
        $utilidad_total_partida = $utilidad_unitaria * $request->cantidad;
        $precio_total_partida = $producto->precio * $request->cantidad;

        try {
            DB::transaction(function () use ($venta, $producto, $request, $utilidad_total_partida, $precio_total_partida) {
                
                // A. Insertar el registro en la tabla venta_detalle
                VentaDetalle::create([
                    'id_venta' => $venta->id,
                    'id_producto' => $producto->upc,
                    'precio' => $producto->precio,
                    'cantidad' => $request->cantidad,
                    'utilidad' => $utilidad_total_partida
                ]);

                // B. Sumar el monto al total de la tabla venta
                $venta->total += $precio_total_partida;
                $venta->save();
            });

            return back()->with('success', 'Producto agregado a la venta correctamente.');

        } catch (Exception $e) {
            return back()->with('error', 'Error al agregar el producto: ' . $e->getMessage());
        }
    }

    ### 4. Función para Eliminar Producto del Detalle (Ejemplo base)
    public function eliminarProducto($id_detalle)
    {
        $detalle = VentaDetalle::findOrFail($id_detalle);
        $venta = Venta::findOrFail($detalle->id_venta);

        // 1. Regla de negocio: No se puede modificar una venta cobrada o cancelada
        if ($venta->estatus != 0) {
            return back()->with('error', 'No se pueden eliminar productos. La venta ya fue procesada.');
        }

        try {
            DB::transaction(function () use ($venta, $detalle) {
                
                // A. Restar el monto de este detalle al total de la venta principal
                $monto_a_restar = $detalle->precio * $detalle->cantidad;
                $venta->total -= $monto_a_restar;
                $venta->save();

                // B. Eliminar el registro de la tabla venta_detalle
                $detalle->delete();
            });

            return back()->with('success', 'Producto eliminado de la venta.');

        } catch (Exception $e) {
            return back()->with('error', 'Error al eliminar el producto: ' . $e->getMessage());
        }
    }
}