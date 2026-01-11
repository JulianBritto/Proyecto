<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema de Solicitudes')</title>
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts for professional look -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
        }
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .btn-primary {
            background: linear-gradient(45deg, #007bff, #0056b3);
            border: none;
            border-radius: 25px;
            padding: 10px 20px;
            font-weight: 500;
        }
        .btn-primary:hover {
            background: linear-gradient(45deg, #0056b3, #004085);
            transform: translateY(-2px);
            transition: all 0.3s ease;
        }
        .footer {
            background: #2c3e50;
            color: white;
            padding: 20px 0;
            margin-top: auto;
        }
        .footer p {
            margin: 0;
            font-size: 0.9rem;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 56px;
            left: 0;
            width: 250px;
            height: calc(100vh - 56px);
            background: #343a40;
            color: white;
            z-index: 1000;
            transition: transform 0.3s ease;
            transform: translateX(-100%);
        }
        .sidebar.show {
            transform: translateX(0);
        }
        .sidebar .nav-link {
            color: rgba(255,255,255,0.8);
            padding: 12px 20px;
            border: none;
            transition: all 0.3s ease;
        }
        .sidebar .nav-link:hover {
            color: white;
            background: rgba(255,255,255,0.1);
        }
        .sidebar .nav-link.active {
            color: white;
            background: #007bff;
        }
        .sidebar .nav-link i {
            margin-right: 10px;
            width: 20px;
        }
        .sidebar .sidebar-header {
            padding: 20px;
            background: #495057;
            border-bottom: 1px solid #6c757d;
        }
        .sidebar .sidebar-header h5 {
            margin: 0;
            color: white;
        }
        .sidebar .sidebar-body {
            padding: 10px 0;
        }
        .sidebar-overlay {
            position: fixed;
            top: 56px;
            left: 0;
            width: 100%;
            height: calc(100vh - 56px);
            background: rgba(0,0,0,0.5);
            z-index: 999;
            display: none;
        }
        .sidebar-overlay.show {
            display: block;
        }
        .main-content {
            transition: margin-left 0.3s ease;
        }
        .main-content.sidebar-open {
            margin-left: 250px;
        }

        @media (max-width: 768px) {
            .sidebar {
                width: 100%;
                z-index: 1050;
            }
            .main-content.sidebar-open {
                margin-left: 0;
            }
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
        <div class="container-fluid">
            @auth
                @if(Auth::user()->role == 1)
                    <button class="btn btn-link text-white me-3" id="sidebarToggle">
                        <i class="fas fa-bars"></i>
                    </button>
                @endif
            @endauth
            <a class="navbar-brand" href="/">
                <i class="fas fa-building me-2"></i>Sistema de Solicitudes Empresarial
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    @auth
                        <li class="nav-item">
                            <span class="nav-link">Hola admin</span>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Cerrar Sesión</a>
                        </li>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            @csrf
                        </form>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Iniciar Sesión</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Sidebar -->
    @auth
        @if(Auth::user()->role == 1 && (request()->is('solicitud*') || request()->is('solicitudes*')))
            <div class="sidebar" id="sidebar">
                <div class="sidebar-header">
                    <h5><i class="fas fa-cog me-2"></i>Menú Admin</h5>
                </div>
                <div class="sidebar-body">
                    <nav class="nav flex-column">
                        <a class="nav-link {{ request()->routeIs('admin.index') ? 'active' : '' }}" href="/admin">
                            <i class="fas fa-tachometer-alt"></i> Panel Administrativo
                        </a>
                        <a class="nav-link {{ request()->routeIs('solicitud.create') ? 'active' : '' }}" href="/solicitud">
                            <i class="fas fa-plus-circle"></i> Crear Solicitud
                        </a>
                        <a class="nav-link {{ request()->routeIs('solicitudes_clientes') ? 'active' : '' }}" href="/solicitudes_clientes">
                            <i class="fas fa-list"></i> Ver Solicitudes
                        </a>
                        <a class="nav-link {{ request()->routeIs('categorias.index') ? 'active' : '' }}" href="/categorias">
                            <i class="fas fa-tags"></i> Gestionar Categorías
                        </a>
                        <a class="nav-link {{ request()->routeIs('categoriasysubcategorias.index') ? 'active' : '' }}" href="/categoriasysubcategorias">
                            <i class="fas fa-table"></i> Tabla Categorías
                        </a>
                    </nav>
                </div>
            </div>
            <div class="sidebar-overlay" id="sidebarOverlay"></div>
        @endif
    @endauth

    <!-- Contenido -->
    <main class="flex-grow-1 py-5">
        <div class="container">
            @yield('content')
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>&copy; {{ date('Y') }} - Sistema de Solicitudes Empresarial. Todos los derechos reservados.</p>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</body>
</html>
