@extends('layouts.admin')

@section('content')

<div class="admin-page-title">
    <p>ESPACE ADMINISTRATEUR</p>
    <h1>Gestion des disponibilités</h1>
    <span>Définir les jours et horaires disponibles pour les rendez-vous.</span>
</div>

<section class="admin-content">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">

        <div class="col-lg-7">
            <div class="admin-table-card">
                <h2>Disponibilités enregistrées</h2>

                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Jour</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($availabilities as $availability)
                            <tr>
                                <td><strong>{{ $availability->day_of_week }}</strong></td>
                                <td>{{ \Carbon\Carbon::parse($availability->start_time)->format('H:i') }}</td>
                                <td>{{ \Carbon\Carbon::parse($availability->end_time)->format('H:i') }}</td>
                                <td>
                                    <form method="POST" action="{{ url('/admin/availability/'.$availability->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-delete">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        @if($availabilities->isEmpty())
                            <tr>
                                <td colspan="4" class="text-center text-muted">
                                    Aucune disponibilité enregistrée.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="admin-table-card sticky-card">
                <h2>Add availability form</h2>

                <form method="POST" action="{{ url('/admin/availability') }}">
                    @csrf

                    <label class="form-label">Jour de la semaine</label>
                    <select name="day_of_week" class="form-control mb-3" required>
                        <option value="">Choisir un jour</option>
                        <option value="Lundi">Lundi</option>
                        <option value="Mardi">Mardi</option>
                        <option value="Mercredi">Mercredi</option>
                        <option value="Jeudi">Jeudi</option>
                        <option value="Vendredi">Vendredi</option>
                        <option value="Samedi">Samedi</option>
                        <option value="Dimanche">Dimanche</option>
                    </select>

                    <label class="form-label">Heure début</label>
                    <input type="time" name="start_time" class="form-control mb-3" required>

                    <label class="form-label">Heure fin</label>
                    <input type="time" name="end_time" class="form-control mb-3" required>

                    <button class="btn-admin-save w-100">
                        + Ajouter disponibilité
                    </button>
                </form>
            </div>
        </div>

    </div>

</section>

@endsection