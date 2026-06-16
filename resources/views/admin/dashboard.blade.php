@extends('layouts.admin')

@section('content')

<div class="admin-page-title">
    <p>ESPACE ADMINISTRATEUR</p>
    <h1>Dashboard</h1>
    <span>Vue générale des indicateurs de réservation et revenu estimé.</span>
</div>

<section class="admin-content">

    <div class="admin-stats-grid">

        <div class="admin-stat-card">
            <div class="stat-icon"><i class="fa-regular fa-calendar-check"></i></div>
            <h3>{{ $total }}</h3>
            <p>Total des rendez-vous</p>
        </div>

        <div class="admin-stat-card">
            <div class="stat-icon"><i class="fa-regular fa-hourglass"></i></div>
            <h3>{{ $pending }}</h3>
            <p>Rendez-vous en attente</p>
        </div>

        <div class="admin-stat-card">
            <div class="stat-icon"><i class="fa-regular fa-circle-check"></i></div>
            <h3>{{ $accepted }}</h3>
            <p>Rendez-vous acceptés</p>
        </div>

        <div class="admin-stat-card">
            <div class="stat-icon"><i class="fa-solid fa-list-check"></i></div>
            <h3>{{ $completed }}</h3>
            <p>Rendez-vous terminés</p>
        </div>

        <div class="admin-stat-card">
            <div class="stat-icon"><i class="fa-regular fa-money-bill-1"></i></div>
            <h3>{{ number_format($revenue, 0, ',', ' ') }} MAD</h3>
            <p>Revenu estimé</p>
        </div>

    </div>

    <div class="admin-table-card">
        <h2>Tableau des rendez-vous récents</h2>

        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Client</th>
                    <th>contact</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Heure</th>
                    <th>Statut</th>
                </tr>
            </thead>

            <tbody>
                @foreach($reservations as $r)
                    <tr>
                        <td><strong>{{ $r->client_name }}</strong></td>
                        <td>{{ $r->phone }}<br><small class="text-muted">{{ $r->email ?? 'Email non renseigné' }}</small></td>
                        <td>{{ $r->service->name }}<br>
                            <small class="text-muted">
                                {{ $r->subService->name ?? 'Sous-service non choisi' }}
                            </small>
                        </td>
                        <td>{{ $r->reservation_date }}</td>
                        <td>{{ substr($r->reservation_time, 0, 5) }}</td>
                        <td>
                            <span class="status-badge {{ $r->status }}">
                                {{ $r->status }}
                            </span>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</section>

@endsection