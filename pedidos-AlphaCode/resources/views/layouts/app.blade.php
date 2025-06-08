<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Pedidos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #4A90E2, #50E3C2);
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            position: relative;
            overflow-x: hidden;
        }

        .auth-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }

        .auth-container .card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: none;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
        }

        .auth-container .btn-primary {
            background: linear-gradient(135deg, #4A90E2, #50E3C2);
            border: none;
            color: white;
            transition: all 0.3s ease;
        }

        .auth-container .btn-primary:hover {
            background: linear-gradient(135deg, #50E3C2, #4A90E2);
            color: white;
            transform: translateY(-1px);
        }

        .auth-container .text-primary {
            color: #4A90E2 !important;
        }

        .auth-container .alert {
            background-color: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .navbar {
            background: rgba(255, 255, 255, 0.1) !important;
            backdrop-filter: blur(10px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            position: relative;
            z-index: 2;
        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(10px);
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            transition: transform 0.3s ease;
            transform: translateX(-250px);
            overflow-x: hidden;
        }

        .sidebar.show {
            transform: translateX(0);
        }

        .main-content {
            margin-left: 0;
            transition: margin-left 0.3s ease;
            width: 100%;
            position: relative;
            z-index: 1;
            background: transparent;
        }

        .main-content.sidebar-visible {
            margin-left: 250px;
        }

        .nav-link {
            color: white !important;
            padding: 0.8rem 1rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #50E3C2 !important;
        }

        .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: #50E3C2 !important;
        }

        .card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        .btn-logout {
            background: transparent;
            border: none;
            color: #ff6b6b;
            font-size: 0.9rem;
            padding: 0.5rem 1rem;
            transition: all 0.3s ease;
        }

        .btn-logout:hover {
            color: #ff4757;
            background: rgba(255, 107, 107, 0.1);
        }

        .btn-menu {
            background: transparent;
            border: none;
            color: white;
            font-size: 1.5rem;
            padding: 0.5rem;
            transition: all 0.3s ease;
            position: relative;
            z-index: 3;
        }

        .btn-menu:hover {
            color: #50E3C2;
        }

        .user-info {
            color: #fff;
            padding: 1rem;
            text-align: center;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .user-info .user-name {
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .user-info .user-role {
            font-size: 0.875rem;
            opacity: 0.8;
        }

        .btn-primary {
            background: linear-gradient(135deg, #4A90E2, #50E3C2);
            border: none;
            color: white;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(74, 144, 226, 0.2);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #50E3C2, #4A90E2);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.3);
        }

        .btn-success {
            background: linear-gradient(135deg, #00b09b, #96c93d);
            border: none;
            color: white;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 176, 155, 0.2);
        }

        .btn-success:hover {
            background: linear-gradient(135deg, #96c93d, #00b09b);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 176, 155, 0.3);
        }

        .btn-danger {
            background: linear-gradient(135deg, #FF416C, #FF4B2B);
            border: none;
            color: white;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(255, 65, 108, 0.2);
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #FF4B2B, #FF416C);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 65, 108, 0.3);
        }

        .btn-warning {
            background: linear-gradient(135deg, #f6d365, #fda085);
            border: none;
            color: white;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(246, 211, 101, 0.2);
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #fda085, #f6d365);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(246, 211, 101, 0.3);
        }

        .btn-info {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            border: none;
            color: white;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(79, 172, 254, 0.2);
        }

        .btn-info:hover {
            background: linear-gradient(135deg, #00f2fe, #4facfe);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 172, 254, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #6c757d, #495057);
            border: none;
            color: white;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(108, 117, 125, 0.2);
        }

        .btn-secondary:hover {
            background: linear-gradient(135deg, #495057, #6c757d);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.3);
        }

        .btn-light {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border: none;
            color: #495057;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(248, 249, 250, 0.2);
        }

        .btn-light:hover {
            background: linear-gradient(135deg, #e9ecef, #f8f9fa);
            color: #212529;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(248, 249, 250, 0.3);
        }

        .btn-dark {
            background: linear-gradient(135deg, #343a40, #212529);
            border: none;
            color: white;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(52, 58, 64, 0.2);
        }

        .btn-dark:hover {
            background: linear-gradient(135deg, #212529, #343a40);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 58, 64, 0.3);
        }

        .btn-link {
            background: none;
            border: none;
            color: #4A90E2;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            transition: all 0.3s ease;
        }

        .btn-link:hover {
            color: #357ABD;
            text-decoration: none;
            transform: translateY(-1px);
        }

        .btn-outline-primary {
            background: transparent;
            border: 2px solid #4A90E2;
            color: #4A90E2;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-primary:hover {
            background: linear-gradient(135deg, #4A90E2, #50E3C2);
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(74, 144, 226, 0.3);
        }

        .btn-outline-success {
            background: transparent;
            border: 2px solid #00b09b;
            color: #00b09b;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-success:hover {
            background: linear-gradient(135deg, #00b09b, #96c93d);
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 176, 155, 0.3);
        }

        .btn-outline-danger {
            background: transparent;
            border: 2px solid #FF416C;
            color: #FF416C;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-danger:hover {
            background: linear-gradient(135deg, #FF416C, #FF4B2B);
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 65, 108, 0.3);
        }

        .btn-outline-warning {
            background: transparent;
            border: 2px solid #f6d365;
            color: #f6d365;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-warning:hover {
            background: linear-gradient(135deg, #f6d365, #fda085);
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(246, 211, 101, 0.3);
        }

        .btn-outline-info {
            background: transparent;
            border: 2px solid #4facfe;
            color: #4facfe;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-info:hover {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 172, 254, 0.3);
        }

        .btn-outline-secondary {
            background: transparent;
            border: 2px solid #6c757d;
            color: #6c757d;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-secondary:hover {
            background: linear-gradient(135deg, #6c757d, #495057);
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(108, 117, 125, 0.3);
        }

        .btn-outline-light {
            background: transparent;
            border: 2px solid #f8f9fa;
            color: #f8f9fa;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-light:hover {
            background: linear-gradient(135deg, #f8f9fa, #e9ecef);
            border-color: transparent;
            color: #495057;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(248, 249, 250, 0.3);
        }

        .btn-outline-dark {
            background: transparent;
            border: 2px solid #343a40;
            color: #343a40;
            font-weight: 500;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-outline-dark:hover {
            background: linear-gradient(135deg, #343a40, #212529);
            border-color: transparent;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(52, 58, 64, 0.3);
        }

        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.3);
            backdrop-filter: blur(3px);
            z-index: 999;
            display: none;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .overlay.show {
            display: block;
            opacity: 1;
        }
    </style>
</head>
<body>
    @auth
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <div class="p-3">
            <div class="text-center mb-4">
                <h4 class="text-white mb-0">Sistema de Pedidos</h4>
            </div>
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Administrador</div>
            </div>
            <nav class="nav flex-column mt-4">
                <a href="{{ route('dashboard') }}" class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2 me-2"></i> Dashboard
                </a>
                <a href="{{ route('pedidos.index') }}" class="nav-link {{ request()->routeIs('pedidos.*') ? 'active' : '' }}">
                    <i class="bi bi-cart me-2"></i> Pedidos
                </a>
                <a href="{{ route('clientes.index') }}" class="nav-link {{ request()->routeIs('clientes.*') ? 'active' : '' }}">
                    <i class="bi bi-people me-2"></i> Clientes
                </a>
                <a href="{{ route('produtos.index') }}" class="nav-link {{ request()->routeIs('produtos.*') ? 'active' : '' }}">
                    <i class="bi bi-box me-2"></i> Produtos
                </a>
            </nav>
            <div class="mt-auto pt-3">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-logout w-100">
                        <i class="bi bi-box-arrow-right me-2"></i> Sair
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content" id="mainContent">
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg">
            <div class="container-fluid">
                <div class="d-flex align-items-center">
                    <button class="btn-menu" id="toggleSidebar">
                        <i class="bi bi-list"></i>
                    </button>
                    <span class="ms-3 text-primary fw-bold">AlphaCodeSystem</span>
                </div>
                <div class="ms-auto">
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-logout">
                            <i class="bi bi-box-arrow-right"></i> Sair
                        </button>
                    </form>
                </div>
            </div>
        </nav>

        <!-- Page Content -->
        <div class="container-fluid py-4">
            @yield('content')
        </div>
    </div>
    @else
    <div class="auth-container">
        @yield('content')
    </div>
    @endauth

    <div class="overlay" id="sidebarOverlay"></div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.querySelector('.sidebar');
            const mainContent = document.querySelector('.main-content');
            const menuButton = document.querySelector('.btn-menu');
            const overlay = document.getElementById('sidebarOverlay');

            function toggleSidebar() {
                sidebar.classList.toggle('show');
                mainContent.classList.toggle('sidebar-visible');
                overlay.classList.toggle('show');
            }

            menuButton.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);

            // Fechar o sidebar em telas pequenas quando clicar em um link
            const sidebarLinks = document.querySelectorAll('.sidebar .nav-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth < 768) {
                        toggleSidebar();
                    }
                });
            });
        });
    </script>
    @stack('scripts')
    @yield('scripts')
</body>
</html>
