<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Telkom Foodies')</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Telkom Theme -->
    <link href="{{ asset('css/telkom-theme.css') }}" rel="stylesheet">
    <style>
        .transparent-header {
            background-color: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            padding: 1rem 0;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        
        .site-logo {
            font-size: 1.5rem;
            font-weight: bold;
            color: #e42313;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .site-logo:hover {
            color: #b91c1c;
        }
        
        .logout-btn {
            color: #6b7280;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        
        .logout-btn:hover {
            color: #4b5563;
        }
        
        .main-content {
            padding-top: 80px; /* Adjust based on header height */
        }
    </style>
</head>
<body>
    <!-- Transparent Header -->
    <header class="transparent-header">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center">
                <a href="{{ route('dashboard') }}" class="site-logo">
                    <i class="fas fa-utensils me-2"></i>Telkom Foodies
                </a>
                <div>
                    @auth
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn logout-btn">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <div class="main-content">
        @yield('content')
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
