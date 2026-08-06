<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Ventas</title>
    <!-- Incluimos Bootstrap para los estilos y componentes web -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Iconos de Bootstrap (opcional, para que se vea mejor) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
</head>
<body class="bg-light">

    <!-- MENÚ DE NAVEGACIÓN SUPERIOR (NAVBAR) -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-shop"></i> Sistema de ventas
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <!-- Enlaces a los diferentes módulos usando la función url() de Laravel -->
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ url('/') }}">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/ventas') }}">Ventas</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/productos') }}">Productos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/clientes') }}">Clientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ url('/empleados') }}">Empleados</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENEDOR PRINCIPAL -->
    <div class="container">
        
        <div class="row mb-4">
            <div class="col-12">
                <h1 class="display-6">Bienvenido al Panel de Control</h1>
                <p class="text-muted">Selecciona un módulo para comenzar a trabajar.</p>
            </div>
        </div>

        <!-- WIDGET DEL TIPO DE CAMBIO (BANXICO) -->
        <div class="row mb-5">
            <div class="col-md-6 col-lg-4">
                <div class="card text-bg-info mb-3 shadow-sm">
                    <div class="card-header fw-bold">
                        <i class="bi bi-currency-exchange"></i> Tipo de Cambio Actual
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">Banco de México</h5>
                        
                        <p class="card-text fs-4">1 USD = <strong>${{ $tipoCambio }}</strong> MXN</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- MENÚ DE TARJETAS (DASHBOARD) -->
        <div class="row g-4">
            
            <!-- Tarjeta Módulo de Ventas -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm border-primary">
                    <div class="card-body text-center">
                        <h1 class="text-primary mb-3"><i class="bi bi-cart-check"></i></h1>
                        <h5 class="card-title">Módulo de Ventas</h5>
                        <p class="card-text text-muted">Crear ventas, agregar productos, cobrar y cancelar.</p>
                        <a href="{{ url('/ventas') }}" class="btn btn-outline-primary w-100">Ir a Ventas</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Módulo de Productos -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm border-success">
                    <div class="card-body text-center">
                        <h1 class="text-success mb-3"><i class="bi bi-box-seam"></i></h1>
                        <h5 class="card-title">Productos</h5>
                        <p class="card-text text-muted">Gestión de inventario, altas, bajas y modificaciones.</p>
                        <a href="{{ url('/productos') }}" class="btn btn-outline-success w-100">Ir a Productos</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Módulo de Clientes -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm border-warning">
                    <div class="card-body text-center">
                        <h1 class="text-warning mb-3"><i class="bi bi-people"></i></h1>
                        <h5 class="card-title">Clientes</h5>
                        <p class="card-text text-muted">Directorio de clientes y registro de datos.</p>
                        <a href="{{ url('/clientes') }}" class="btn btn-outline-warning w-100">Ir a Clientes</a>
                    </div>
                </div>
            </div>

            <!-- Tarjeta Módulo de Empleados -->
            <div class="col-md-6 col-lg-3">
                <div class="card h-100 shadow-sm border-secondary">
                    <div class="card-body text-center">
                        <h1 class="text-secondary mb-3"><i class="bi bi-person-badge"></i></h1>
                        <h5 class="card-title">Empleados</h5>
                        <p class="card-text text-muted">Administración del personal y usuarios del sistema.</p>
                        <a href="{{ url('/empleados') }}" class="btn btn-outline-secondary w-100">Ir a Empleados</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Scripts de Bootstrap requeridos para el funcionamiento del menú móvil -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>