@extends('layouts.app')

@section('content')

<section class="admin-section">
    <div class="container">

        <div class="admin-card">

            <div class="admin-left">
                <div class="admin-logo">✦</div>

                <h2>Espace Cabinet Lina</h2>

                <p>
                    Prototype admin pour suivre les rendez-vous,
                    services et disponibilités.
                </p>
            </div>

            <div class="admin-right">

                <h3>Connexion admin</h3>

                <p class="admin-subtitle">
                    Connectez-vous pour accéder à l’espace administrateur.
                </p>

                @if($errors->any())
                    <div class="alert alert-danger">
                        Email ou mot de passe incorrect.
                    </div>
                @endif

                <form method="POST" action="{{ url('/admin/login') }}">
                    @csrf

                    <div class="mb-3">
                        <label>Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            placeholder="admin@cabinetlina.ma"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label>Mot de passe</label>
                        <input
                            type="password"
                            name="password"
                            class="form-control"
                            placeholder="********"
                            required
                        >
                    </div>

                    <button type="submit" class="btn-admin w-100">
                        Se connecter
                    </button>
                </form>

            </div>

        </div>

    </div>
</section>

@endsection