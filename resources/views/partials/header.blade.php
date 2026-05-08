<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cabinet Lina Esthétique</title>

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    {{-- CSS ديالنا --}}
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/services.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>
    <header class="lina-header">
    <nav class="navbar navbar-expand-lg">
        <div class="container">

            <a class="navbar-brand lina-logo" href="/">
                <div class="logo-icon"><img src="{{ asset('images/pfelogo.png') }}" alt="logo"></div>
                <div>
                    <div class="logo-title">Cabinet Lina</div>
                    <div class="logo-subtitle">ESTHÉTIQUE</div>
                </div>
            </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNavbar">
                <ul class="navbar-nav mx-auto lina-menu">

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="/">
                        Accueil
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('services') ? 'active' : '' }}" href="{{ url('/services') }}">
                        Services
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('reservation') ? 'active' : '' }}" href="{{ url('/reservation') }}">
                        Réservation
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('admin/login') ? 'active' : '' }}" href="{{ url('/admin/login') }}">
                            Espace Admin
                        </a>
                    </li>

                </ul>

                <div class="header-right">
                    <a href="tel:+212678758595"><span class="phone"><i class="fa-solid fa-phone"></i> +212 678758595</span></a>
                    <a href="{{ url('/reservation') }}" class="btn-header"><i class="fa-solid fa-calendar-days"></i> Réserver</a>
                </div>
            </div>

        </div>
    </nav>
    </header>
</body>
</html>
