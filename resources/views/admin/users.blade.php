@extends('layouts.admin')

@section('content')

<div class="admin-page-title">
    <p>ESPACE ADMINISTRATEUR</p>
    <h1>Gestion des utilisateurs</h1>
    <span>Ajouter, modifier ou supprimer les utilisateurs de l’espace admin.</span>
</div>

<section class="admin-content">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">Vérifiez les informations saisies.</div>
    @endif

    <div class="row g-4">

        <div class="col-lg-7">
            <div class="admin-table-card">
                <h2>Liste des utilisateurs</h2>

                <table class="table align-middle">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Rôle</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td><strong>{{ $user->name }}</strong></td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="status-badge {{ $user->role }}">
                                        {{ $user->role }}
                                    </span>
                                </td>

                                <td>

                                    @if(auth()->id() !== $user->id)
                                        <form method="POST" action="{{ url('/admin/users/'.$user->id) }}" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn-delete">Supprimer</button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>

        <div class="col-lg-5">
            <div class="admin-table-card sticky-card">
                <h2>Ajouter un utilisateur</h2>

                <form method="POST" action="{{ url('/admin/users') }}">
                    @csrf

                    <label class="form-label">Nom complet</label>
                    <input type="text" name="name" class="form-control mb-3" required>

                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control mb-3" required>

                    <label class="form-label">Mot de passe</label>
                    <input type="password" name="password" class="form-control mb-3" required>

                    <label class="form-label">Rôle</label>
                    <select name="role" class="form-control mb-3" required>
                        <option value="staff">équipe</option>
                        <option value="super_admin">Super Admin</option>
                    </select>

                    <button class="btn-admin-save w-100">
                        + Ajouter utilisateur
                    </button>
                </form>
            </div>
        </div>

    </div>

</section>

@endsection