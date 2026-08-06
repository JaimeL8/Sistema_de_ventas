<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Módulo de Clientes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    
    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">Volver al Inicio</a>
        </div>
    </nav>

    <div class="container">
        <!-- Alertas de Errores y Éxito -->
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Directorio de Clientes</h1>
            <button class="btn btn-primary" onclick="abrirModalCrear()">+ Nuevo Cliente</button>
        </div>
        
        <table class="table table-bordered bg-white shadow-sm table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre Completo</th>
                    <th>Email</th>
                    <th>Usuario</th>
                    <th>Fecha Nac.</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clientes as $cliente)
                <tr>
                    <td>{{ $cliente->id }}</td>
                    <td>{{ $cliente->nombre }} {{ $cliente->apellido }}</td>
                    <td>{{ $cliente->email ?? 'N/A' }}</td>
                    <td>{{ $cliente->usuario ?? 'N/A' }}</td>
                    <td>{{ $cliente->fecha_nacimiento ?? 'N/A' }}</td>
                    <td>
                        <!-- Botón Cambio  -->
                        <button class="btn btn-sm btn-warning" onclick="abrirModalEditar({{ $cliente->id }}, '{{ $cliente->nombre }}', '{{ $cliente->apellido }}', '{{ $cliente->direccion }}', '{{ $cliente->email }}', '{{ $cliente->usuario }}', '{{ $cliente->fecha_nacimiento }}')">Editar</button>
                        
                        <!-- Botón Baja -->
                        <form action="{{ url('/clientes/'.$cliente->id) }}" method="POST" class="d-inline" onsubmit="return confirm('¿Seguro que deseas eliminar a este cliente?');">
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
    <div class="modal fade" id="modalCliente" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitulo">Nuevo Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                
                <form id="formCliente" action="{{ url('/clientes') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">
                    
                    <div class="modal-body">
                        <div class="row">
                            <!-- Columna 1 -->
                            <div class="col-md-6 mb-3">
                                <label>Nombre *</label>
                                <input type="text" name="nombre" id="nombre" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label>Apellido *</label>
                                <input type="text" name="apellido" id="apellido" class="form-control" required>
                            </div>
                            
                            <!-- Columna 2 -->
                            <div class="col-md-12 mb-3">
                                <label>Dirección</label>
                                <input type="text" name="direccion" id="direccion" class="form-control" placeholder="Calle, Número, Ciudad...">
                            </div>
                            
                            <!-- Columna 3 -->
                            <div class="col-md-4 mb-3">
                                <label>Email</label>
                                <input type="email" name="email" id="email" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Usuario</label>
                                <input type="text" name="usuario" id="usuario" class="form-control">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label>Fecha de Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" id="fecha_nacimiento" class="form-control">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-success">Guardar Cliente</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        const modal = new bootstrap.Modal(document.getElementById('modalCliente'));
        const form = document.getElementById('formCliente');
        
        function abrirModalCrear() {
            form.reset();
            form.action = "{{ url('/clientes') }}";
            document.getElementById('formMethod').value = "POST";
            document.getElementById('modalTitulo').innerText = 'Nuevo Cliente';
            modal.show();
        }

        function abrirModalEditar(id, nombre, apellido, direccion, email, usuario, fecha_nacimiento) {
            form.action = "{{ url('/clientes') }}/" + id;
            document.getElementById('formMethod').value = "PUT";
            
            document.getElementById('nombre').value = nombre;
            document.getElementById('apellido').value = apellido;
            document.getElementById('direccion').value = direccion;
            document.getElementById('email').value = email;
            document.getElementById('usuario').value = usuario;
            document.getElementById('fecha_nacimiento').value = fecha_nacimiento;
            
            document.getElementById('modalTitulo').innerText = 'Editar Cliente';
            modal.show();
        }
    </script>
</body>
</html>