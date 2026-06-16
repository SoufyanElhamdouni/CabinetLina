<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Admin - Cabinet Lina</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<div class="admin-layout">

    <aside class="admin-sidebar">
        <h2>Cabinet Lina</h2>
        <p>ADMIN ESTHÉTIQUE</p>

        <nav class="admin-menu">

            @if(auth()->user()->role === 'super_admin')
                <a class="{{ request()->is('admin/dashboard') ? 'active' : '' }}" href="{{ url('/admin/dashboard') }}">
                    <i class="fa-solid fa-table-cells-large"></i> Dashboard
                </a>
            @endif

            <a class="{{ request()->is('admin/appointments') ? 'active' : '' }}" href="{{ url('/admin/appointments') }}">
                <i class="fa-regular fa-calendar-check"></i> Rendez-vous
            </a>

            @if(auth()->user()->role === 'super_admin')
                <a class="{{ request()->is('admin/services') ? 'active' : '' }}" href="{{ url('/admin/services') }}">
                    <i class="fa-solid fa-scissors"></i> Services
                </a>

                <a class="{{ request()->is('admin/availability') ? 'active' : '' }}" href="{{ url('/admin/availability') }}">
                    <i class="fa-regular fa-clock"></i> Disponibilités
                </a>

                <a class="{{ request()->is('admin/users') ? 'active' : '' }}" href="{{ url('/admin/users') }}">
                    <i class="fa-regular fa-user"></i> Utilisateurs
                </a>
            @endif

        </nav>
        <form method="POST" action="{{ url('/admin/logout') }}" class="logout-form">
            @csrf
            <button class="btn-logout w-100">
                <i class="fa fa-sign-out" aria-hidden="true"></i> Se Déconnecter
            </button>
        </form>
    </aside>

    <main class="admin-main">
        @yield('content')
    </main>

</div>

</body>
</html>