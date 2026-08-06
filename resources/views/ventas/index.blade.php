<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Ventas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container"><a class="navbar-brand" href="{{ url('/') }}">Volver al Inicio</a></div>
    </nav>

    <div class="container">
        @if(session('success')) <div class="alert alert-success">{{ session('success') }}</div> @endif
        @if(session('error')) <div class="alert alert-danger">{{ session('error') }}</div> @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Consulta de Ventas</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalNuevaVenta">+ Nueva Venta</button>
        </div>
        
        <table class="table table-bordered bg-white shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>Folio (ID)</th>
                    <th>Cliente</th>
                    <th>Atendió</th>
                    <th>Total</th>
                    <th>Estatus</th>
                    <th>Fecha</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ventas as $venta)
                <tr>
                    <td>#{{ $venta->id }}</td>
                    <td>{{ $venta->cliente->nombre }} {{ $venta->cliente->apellido }}</td>
                    <td>{{ $venta->empleado->nombre }}</td>
                    <td><b>${{ number_format($venta->total, 2) }}</b></td>
                    <td>
                        @if($venta->estatus == 0) <span class="badge bg-warning text-dark">Abierta</span>
                        @elseif($venta->estatus == 1) <span class="badge bg-success">Cobrada</span>
                        @else <span class="badge bg-danger">Cancelada</span> @endif
                    </td>
                    <td>{{ $venta->created_at->format('d/m/Y H:i') }}</td>
                    <td>
                        <a href="{{ url('/ventas/'.$venta->id) }}" class="btn btn-sm btn-info text-white">Ver / Gestionar</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal Nueva Venta -->
    <div class="modal fade" id="modalNuevaVenta" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header"><h5 class="modal-title">Iniciar Nueva Venta</h5><button class="btn-close" data-bs-dismiss="modal"></button></div>
                <form action="{{ url('/ventas') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Seleccionar Cliente</label>
                            <select name="id_cliente" class="form-select" required>
                                <option value="">-- Elige un cliente --</option>
                                @foreach($clientes as $cliente) <option value="{{ $cliente->id }}">{{ $cliente->nombre }} {{ $cliente->apellido }}</option> @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label>Seleccionar Empleado (Vendedor)</label>
                            <select name="id_empleado" class="form-select" required>
                                <option value="">-- Elige un empleado --</option>
                                @foreach($empleados as $empleado) <option value="{{ $empleado->id }}">{{ $empleado->nombre }} {{ $empleado->apellido }}</option> @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer"><button type="submit" class="btn btn-success">Crear e Ir al Detalle</button></div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>