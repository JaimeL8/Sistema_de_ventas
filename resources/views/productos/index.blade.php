<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Volver al Inicio</a>
        </div>
    </nav>

    <div class="container">
        <!-- Alertas de éxito -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">Revisa los datos ingresados. (El UPC debe ser único)</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Gestión de Productos</h1>
            <!-- Botón para Alta -->
            <button class="btn btn-primary" onclick="abrirModalCrear()">+ Nuevo Producto</button>
        </div>
        
        <table class="table table-bordered bg-white shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>UPC</th>
                    <th>Descripción</th>
                    <th>Costo</th>
                    <th>Precio</th>
                    <th>Existencia</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($productos as $producto)
                <tr>
                    <td>{{ $producto->upc }}</td>
                    <td>{{ $producto->descripcion }}</td>
                    <td>${{ $producto->costo }}</td>
                    <td>${{ $producto->precio }}</td>
                    <td>{{ $producto->existencia }}</td>
                    <td>
                        <!-- Botón Cambio -->
                        <button class="btn btn-sm btn-warning" onclick="abrirModalEditar('{{ $producto->upc }}', '{{ $producto->descripcion }}', '{{ $producto->costo }}', '{{ $producto->precio }}', '{{ $producto->existencia }}')">Editar</button>
                        
                        <!-- Botón Baja (Formulario invisible) -->
                        <form action="{{ url('/productos/'.$producto->upc) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar este producto?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal para Altas y Cambios -->
    <div class="modal fade" id="modalProducto" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitulo">Nuevo Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <!-- El formulario apunta por defecto a POST /productos -->
                <form id="formProducto" action="{{ url('/productos') }}" method="POST">
                    @csrf
                    
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>UPC (Código)</label>
                            <input type="text" name="upc" id="upc" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label>Descripción</label>
                            <input type="text" name="descripcion" id="descripcion" class="form-control" required>
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label>Costo</label>
                                <input type="number" step="0.01" name="costo" id="costo" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Precio</label>
                                <input type="number" step="0.01" name="precio" id="precio" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Existencia</label>
                                <input type="number" name="existencia" id="existencia" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const modal = new bootstrap.Modal(document.getElementById('modalProducto'));
        const form = document.getElementById('formProducto');
        
        function abrirModalCrear() {
            // Limpiar formulario y configurarlo para GUARDAR (POST)
            form.reset();
            form.action = "{{ url('/productos') }}";
            document.getElementById('formMethod').value = "POST";
            document.getElementById('upc').readOnly = false; // Permitir escribir el UPC
            document.getElementById('modalTitulo').innerText = 'Nuevo Producto';
            modal.show();
        }

        function abrirModalEditar(upc, descripcion, costo, precio, existencia) {
            // Llenar datos y configurarlo para ACTUALIZAR (PUT)
            form.action = "{{ url('/productos') }}/" + upc;
            document.getElementById('formMethod').value = "PUT";
            
            document.getElementById('upc').value = upc;
            document.getElementById('upc').readOnly = true; // No permitir cambiar la llave primaria
            
            document.getElementById('descripcion').value = descripcion;
            document.getElementById('costo').value = costo;
            document.getElementById('precio').value = precio;
            document.getElementById('existencia').value = existencia;
            
            document.getElementById('modalTitulo').innerText = 'Editar Producto';
            modal.show();
        }
    </script>
</body>
</html>