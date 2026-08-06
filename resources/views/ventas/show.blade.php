<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalle de Venta #{{ $venta->id }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container"><a class="navbar-brand" href="{{ url('/ventas') }}">Volver a Ventas</a></div>
    </nav>

    <div class="container">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif
        @if($errors->any()) <div class="alert alert-danger">Error al procesar la petición.</div> @endif

        <div class="row">
            <!-- PANEL IZQUIERDO: Información y Agregar Productos -->
            <div class="col-md-4">
                <div class="card mb-3 shadow-sm">
                    <div class="card-body">
                        <h5>Venta Folio: #{{ $venta->id }}</h5>
                        <p class="mb-1"><b>Cliente:</b> {{ $venta->cliente->nombre }} {{ $venta->cliente->apellido }}</p>
                        <p class="mb-1"><b>Atiende:</b> {{ $venta->empleado->nombre }}</p>
                        <hr>
                        <h3 class="text-primary text-center">Total: ${{ number_format($venta->total, 2) }}</h3>
                        
                        <div class="text-center mt-3">
                            @if($venta->estatus == 0)
                                <span class="badge bg-warning fs-6 mb-3 text-dark">ESTATUS: ABIERTA</span>
                                <!-- Botón Cobrar -->
                                <form action="{{ url('/ventas/'.$venta->id.'/cobrar') }}" method="POST" onsubmit="return confirm('¿Seguro que deseas COBRAR esta venta? Ya no podrás modificarla.');">
                                    @csrf
                                    <button class="btn btn-success w-100 btn-lg">💰 COBRAR VENTA</button>
                                </form>
                            @elseif($venta->estatus == 1)
                                <span class="badge bg-success fs-6 mb-3">ESTATUS: COBRADA</span>
                                <!-- Botón Cancelar -->
                                <form action="{{ url('/ventas/'.$venta->id.'/cancelar') }}" method="POST" onsubmit="return confirm('¿Seguro que deseas CANCELAR esta venta? El inventario regresará a almacén.');">
                                    @csrf
                                    <button class="btn btn-danger w-100">🚫 CANCELAR VENTA</button>
                                </form>
                            @else
                                <span class="badge bg-danger fs-6 mb-3">ESTATUS: CANCELADA</span>
                                <p class="text-muted small">Esta venta fue anulada.</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Formulario Agregar Producto (Solo visible si estatus == 0) -->
                @if($venta->estatus == 0)
                <div class="card shadow-sm border-primary">
                    <div class="card-header bg-primary text-white">Agregar Producto</div>
                    <div class="card-body">
                        <form action="{{ url('/ventas/'.$venta->id.'/agregar-producto') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label>Producto (Stock disponible)</label>
                                <select name="id_producto" class="form-select" required>
                                    <option value="">-- Elige --</option>
                                    @foreach($productos as $prod)
                                        <option value="{{ $prod->upc }}">{{ $prod->descripcion }} (Stock: {{ $prod->existencia }} | ${{ $prod->precio }})</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label>Cantidad</label>
                                <input type="number" name="cantidad" class="form-control" value="1" min="1" required>
                            </div>
                            <button class="btn btn-primary w-100">Agregar al Carrito</button>
                        </form>
                    </div>
                </div>
                @endif
            </div>

            <!-- PANEL DERECHO: Detalle de Productos -->
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header"><b>Detalle de la Venta (Carrito)</b></div>
                    <div class="card-body p-0">
                        <table class="table table-striped mb-0">
                            <thead>
                                <tr>
                                    <th>UPC</th>
                                    <th>Descripción</th>
                                    <th>Precio U.</th>
                                    <th>Cant.</th>
                                    <th>Subtotal</th>
                                    @if($venta->estatus == 0) <th>Quitar</th> @endif
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($venta->detalles as $detalle)
                                <tr>
                                    <td>{{ $detalle->id_producto }}</td>
                                    <td>{{ $detalle->producto->descripcion ?? 'N/A' }}</td>
                                    <td>${{ number_format($detalle->precio, 2) }}</td>
                                    <td>{{ $detalle->cantidad }}</td>
                                    <td><b>${{ number_format($detalle->precio * $detalle->cantidad, 2) }}</b></td>
                                    @if($venta->estatus == 0)
                                    <td>
                                        <form action="{{ url('/ventas/detalle/'.$detalle->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">X</button>
                                        </form>
                                    </td>
                                    @endif
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">No hay productos agregados a esta venta.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>