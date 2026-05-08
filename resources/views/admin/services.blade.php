@extends('layouts.admin')

@section('content')

<div class="admin-page-title">
    <p>ESPACE ADMINISTRATEUR</p>
    <h1>Gestion des services</h1>
    <span>Liste des prestations, formulaire d’ajout et actions de suppression.</span>
</div>

<section class="admin-content">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">

        <div class="col-lg-6">
            <div class="admin-table-card">
                <h2>List services</h2>

                @foreach($services as $service)

                    <div class="admin-service-item">
                        <div>
                            <strong>{{ $service->name }}</strong>
                            <p>{{ $service->duration_minutes }} min · {{ $service->price ? $service->price.' DH' : 'À définir' }}</p>
                        </div>

                        <div>
                            <button type="button" class="btn-edit"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editService{{ $service->id }}">
                                <i class="fa-solid fa-pencil"></i> Edit
                            </button>

                            <form method="POST" action="{{ url('/admin/services/'.$service->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn-delete">Delete</button>
                            </form>
                        </div>
                    </div>

                    {{-- MODAL ديال edit تحطو هنا --}}
                    <div class="modal fade" id="editService{{ $service->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ url('/admin/services/'.$service->id) }}" class="modal-content">
                                @csrf
                                @method('PUT')

                                <div class="modal-header">
                                    <h5 class="modal-title">Modifier service</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <input name="name" value="{{ $service->name }}" class="form-control mb-3" required>

                                    <input name="duration_minutes" type="number" value="{{ $service->duration_minutes }}" class="form-control mb-3" required>

                                    <input name="price" type="number" step="0.01" value="{{ $service->price }}" class="form-control mb-3">

                                    <textarea name="description" class="form-control mb-3" rows="4" required>{{ $service->description }}</textarea>
                                </div>

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                                    <button type="submit" class="btn-admin-save">Enregistrer</button>
                                </div>
                            </form>
                        </div>
                    </div>

                @endforeach
            </div>
        </div>

        <div class="col-lg-6">
            <div class="admin-table-card">
                <h2>Add service form</h2>

                <form method="POST" action="{{ url('/admin/services') }}">
                    @csrf

                    <input name="name" class="form-control mb-3" placeholder="Titre du service" required>

                    <input name="duration_minutes" type="number" class="form-control mb-3" placeholder="Durée" required>

                    <input name="price" type="number" step="0.01" class="form-control mb-3" placeholder="Prix">

                    <textarea name="description" class="form-control mb-3" rows="4" placeholder="Description" required></textarea>

                    <button class="btn-admin-save w-100">+ Ajouter le service</button>
                </form>
            </div>
        </div>

    </div>

</section>

@endsection