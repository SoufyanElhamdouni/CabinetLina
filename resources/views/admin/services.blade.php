@extends('layouts.admin')

@section('content')

<div class="admin-page-title">
    <p>ESPACE ADMINISTRATEUR</p>
    <h1>Gestion des services</h1>
    <span>Liste des prestations, sous-services et actions de gestion.</span>
</div>

<section class="admin-content">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="row g-4">

        <div class="col-lg-6">
            <div class="admin-table-card">
                <h2>Liste des services</h2>

                @foreach($services as $service)

                    <div class="admin-service-item" onclick="toggleSubServices({{ $service->id }})">
                        <div>
                            <strong>{{ $service->name }}</strong>
                            <p>
                                {{ $service->duration_minutes }} min ·

                                @if($service->subServices->count() > 0)
                                    À partir de {{ number_format($service->subServices->min('price'), 0, ',', ' ') }} DH
                                @elseif($service->price)
                                    {{ $service->price }} DH
                                @else
                                    Aucun prix
                                @endif
                            </p>
                        </div>

                        <div onclick="event.stopPropagation();">
                            <button type="button" class="btn-edit"
                                    data-bs-toggle="modal"
                                    data-bs-target="#editService{{ $service->id }}">
                                <i class="fa-solid fa-pencil"></i> Modifier
                            </button>

                            <form method="POST" action="{{ url('/admin/services/'.$service->id) }}" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button class="btn-delete">Supprimer</button>
                            </form>
                        </div>
                    </div>

                    <div class="admin-subservices-list" id="subservices-{{ $service->id }}" style="display:none;">
                        @forelse($service->subServices as $sub)
                            <div class="admin-subservice-row">
                                <div>
                                    <span>{{ $sub->name }}</span>
                                    <small>{{ $sub->duration_minutes }} min</small>
                                </div>

                                <strong>{{ number_format($sub->price, 0, ',', ' ') }} DH</strong>

                                <div>
                                    <button type="button" class="btn-edit"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editSubService{{ $sub->id }}">
                                        Modifier
                                    </button>

                                    <form method="POST" action="{{ url('/admin/sub-services/'.$sub->id) }}" style="display:inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-delete">Supprimer</button>
                                    </form>
                                </div>
                            </div>

                            <div class="modal fade" id="editSubService{{ $sub->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <form method="POST" action="{{ url('/admin/sub-services/'.$sub->id) }}" class="modal-content">
                                        @csrf
                                        @method('PUT')

                                        <div class="modal-header">
                                            <h5 class="modal-title">Modifier sous-service</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            <input name="name" value="{{ $sub->name }}" class="form-control mb-3" required>

                                            <input name="duration_minutes" type="number" value="{{ $sub->duration_minutes }}" class="form-control mb-3" required>

                                            <input name="price" type="number" step="0.01" value="{{ $sub->price }}" class="form-control mb-3" required>
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Annuler</button>
                                            <button type="submit" class="btn-admin-save">Enregistrer</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-muted mb-0">Aucun sous-service.</p>
                        @endforelse
                    </div>

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
                <h2>Ajouter un service</h2>

                <form method="POST" action="{{ url('/admin/services') }}">
                    @csrf

                    <input name="name" class="form-control mb-3" placeholder="Titre du service" required>

                    <input name="duration_minutes" type="number" class="form-control mb-3" placeholder="Durée" required>

                    <input name="price" type="number" step="0.01" class="form-control mb-3" placeholder="Prix">

                    <textarea name="description" class="form-control mb-3" rows="4" placeholder="Description" required></textarea>

                    <button class="btn-admin-save w-100">+ Ajouter le service</button>
                </form>

                <div class="admin-table-card mt-4">
                    <h2>Ajouter un sous-service</h2>

                    <form method="POST" action="{{ url('/admin/sub-services') }}">
                        @csrf

                        <select name="service_id" class="form-control mb-3" required>
                            <option value="">Choisir service</option>
                            @foreach($services as $service)
                                <option value="{{ $service->id }}">{{ $service->name }}</option>
                            @endforeach
                        </select>

                        <input name="name" class="form-control mb-3" placeholder="Nom du sous-service" required>

                        <input name="duration_minutes" type="number" class="form-control mb-3" placeholder="Durée" required>

                        <input name="price" type="number" step="0.01" class="form-control mb-3" placeholder="Prix" required>

                        <button class="btn-admin-save w-100">
                            + Ajouter sous-service
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>

</section>

<script>
    function toggleSubServices(serviceId) {
        const box = document.getElementById('subservices-' + serviceId);

        if (box.style.display === 'none') {
            box.style.display = 'block';
        } else {
            box.style.display = 'none';
        }
    }
</script>

@endsection