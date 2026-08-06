<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Empleados</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Volver al Inicio</a>
        </div>
    </nav>

    <div class="container">
        <!-- Alertas -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">Por favor revisa los datos ingresados.</div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Directorio de Empleados</h1>
            <!-- Botón para Alta -->
            <button class="btn btn-primary" onclick="abrirModalCrear()">+ Nuevo Empleado</button>
        </div>
        
        <table class="table table-bordered bg-white shadow-sm">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($empleados as $empleado)
                <tr>
                    <td>{{ $empleado->id }}</td>
                    <td>{{ $empleado->nombre }}</td>
                    <td>{{ $empleado->apellido }}</td>
                    <td>{{ $empleado->telefono ?? 'N/A' }}</td>
                    <td>
                        <!-- Botón Cambio -->
                        <button class="btn btn-sm btn-warning" onclick="abrirModalEditar({{ $empleado->id }}, '{{ $empleado->nombre }}', '{{ $empleado->apellido }}', '{{ $empleado->telefono }}')">Editar</button>
                        
                        <!-- Botón Baja -->
                        <form action="{{ url('/empleados/'.$empleado->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar a este empleado?');">
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
    <div class="modal fade" id="modalEmpleado" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitulo">Nuevo Empleado</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <form id="formEmpleado" action="{{ url('/empleados') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    
                    <div class="modal-body">
                        <div class="mb-3">
                            <label>Nombre</label>
                            <input type="text" name="nombre" id="nombre" class="form-control" placeholder="Ej. Ricardo" required>
                        </div>
                        <div class="mb-3">
                            <label>Apellido</label>
                            <input type="text" name="apellido" id="apellido" class="form-control" placeholder="Ej. Almada Díaz" required>
                        </div>
                        <div class="mb-3">
                            <label>Teléfono (Opcional)</label>
                            <input type="text" name="telefono" id="telefono" class="form-control" placeholder="Ej. 4491234567">
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
    
    <!-- JAVASCRIPT PARA MANEJAR EL MODAL -->
    <script>
        const modal = new bootstrap.Modal(document.getElementById('modalEmpleado'));
        const form = document.getElementById('formEmpleado');
        
        function abrirModalCrear() {
            form.reset();
            form.action = "{{ url('/empleados') }}";
            document.getElementById('formMethod').value = "POST";
            document.getElementById('modalTitulo').innerText = 'Nuevo Empleado';
            modal.show();
        }

        function abrirModalEditar(id, nombre, apellido, telefono) {
            form.action = "{{ url('/empleados') }}/" + id;
            document.getElementById('formMethod').value = "PUT";
            
            document.getElementById('nombre').value = nombre;
            document.getElementById('apellido').value = apellido;
            document.getElementById('telefono').value = telefono;
            
            document.getElementById('modalTitulo').innerText = 'Editar Empleado';
            modal.show();
        }
    </script>
</body>
</html>