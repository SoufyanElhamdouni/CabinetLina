@extends('layouts.admin')

@section('content')

<div class="admin-page-title">
    <p>ESPACE ADMINISTRATEUR</p>
    <h1>Gestion des rendez-vous</h1>
    <span>Ajouter manuellement un rendez-vous et gérer les demandes des clients.</span>
</div>

<section class="admin-content">

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            Ce créneau est déjà réservé ou les informations sont incorrectes.
        </div>
    @endif

    {{-- FORM AJOUT RENDEZ-VOUS --}}
    <div class="admin-table-card mb-4">
        <h2>+ Ajouter rendez-vous</h2>

        <form method="POST" action="{{ url('/admin/appointments/store') }}">
            @csrf

            <div class="row g-3">
                <div class="col-md-4">
                    <label>Service</label>
                    <select name="service_id" id="admin_service_id" class="form-control" required>
                        <option value="">Choisir service</option>
                        @foreach($services as $service)
                            <option value="{{ $service->id }}">{{ $service->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Sous-service</label>
                    <select name="sub_service_id" id="admin_sub_service_id" class="form-control">
                        <option value="">Choisir sous-service</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Date</label>
                    <input type="date" name="reservation_date" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label>Heure</label>
                    <input type="time" name="reservation_time" class="form-control" required>
                </div>

                <div class="col-md-4">
                    <label>Nom client</label>
                    <input 
                        type="text" 
                        name="client_name" 
                        class="form-control"
                        pattern="^[A-Za-zÀ-ÿ\s'-]+$"
                        title="Le nom doit contenir uniquement des lettres."
                        required
                    >
                </div>

                <div class="col-md-4">
                    <label>Téléphone</label>
                    <input 
                        type="tel" 
                        name="phone" 
                        class="form-control"
                        pattern="^[0-9]{10}$"
                        maxlength="10"
                        inputmode="numeric"
                        title="Le téléphone doit contenir exactement 10 chiffres."
                        required
                    >
                </div>

                <div class="col-md-8">
                    <label>Email</label>
                    <input 
                        type="email" 
                        name="email" 
                        class="form-control"
                        pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$"
                        title="Veuillez saisir un email valide sans espaces."
                    >
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn-admin-save w-100">
                        + Ajouter
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- TABLE RENDEZ-VOUS --}}
    <div class="admin-table-card">
        <div class="appointment-filters">
    <button class="filter-btn active" data-filter="all">
        Tous <span>{{ $reservations->count() }}</span>
    </button>

    <button class="filter-btn" data-filter="pending">
        Pending <span>{{ $reservations->where('status', 'pending')->count() }}</span>
    </button>

    <button class="filter-btn" data-filter="accepted">
        Accepted <span>{{ $reservations->where('status', 'accepted')->count() }}</span>
    </button>

    <button class="filter-btn" data-filter="completed">
        Completed <span>{{ $reservations->where('status', 'completed')->count() }}</span>
    </button>

    <button class="filter-btn" data-filter="refused">
        Refused <span>{{ $reservations->where('status', 'refused')->count() }}</span>
    </button>

    <button class="filter-btn" data-filter="cancelled">
        Cancelled <span>{{ $reservations->where('status', 'cancelled')->count() }}</span>
    </button>
</div>
        <table class="table align-middle">
            <thead>
                <tr>
                    <th>Client name</th>
                    <th>Contact</th>
                    <th>Service</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                @foreach($reservations as $r)
                    <tr class="appointment-row" data-status="{{ $r->status }}">
                        <td><strong>{{ $r->client_name }}</strong></td>

                        <td>
                            {{ $r->phone }}
                            <br>
                            <small class="text-muted">{{ $r->email ?? 'Email non renseigné' }}</small>
                        </td>

                        <td>
                            {{ $r->service->name ?? '-' }}
                            <br>
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

                        <td>
                            <div class="admin-actions">
                                <form method="POST" action="{{ url('/admin/appointments/'.$r->id.'/accepted') }}">
                                    @csrf
                                    <button>Accept</button>
                                </form>

                                <form method="POST" action="{{ url('/admin/appointments/'.$r->id.'/refused') }}">
                                    @csrf
                                    <button>Refuse</button>
                                </form>

                                <form method="POST" action="{{ url('/admin/appointments/'.$r->id.'/cancelled') }}">
                                    @csrf
                                    <button>Cancel</button>
                                </form>

                                <form method="POST" action="{{ url('/admin/appointments/'.$r->id.'/completed') }}">
                                    @csrf
                                    <button class="complete">Complete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</section>

<script>
    const adminServices = @json($services);

    const serviceSelect = document.getElementById('admin_service_id');
    const subServiceSelect = document.getElementById('admin_sub_service_id');

    serviceSelect.addEventListener('change', function () {
        const serviceId = this.value;

        subServiceSelect.innerHTML = '<option value="">Choisir sous-service</option>';

        const service = adminServices.find(s => s.id == serviceId);

        if (service && service.sub_services) {
            service.sub_services.forEach(sub => {
                const option = document.createElement('option');
                option.value = sub.id;
                option.textContent = `${sub.name} - ${sub.price ?? 0} DH`;
                subServiceSelect.appendChild(option);
            });
        }
    });
</script>

<script>
    document.querySelectorAll('.filter-btn').forEach(button => {
        button.addEventListener('click', function () {
            const filter = this.dataset.filter;

            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');

            document.querySelectorAll('.appointment-row').forEach(row => {
                if (filter === 'all' || row.dataset.status === filter) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
        });
    });
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const nameInput = document.querySelector('input[name="client_name"]');
    const phoneInput = document.querySelector('input[name="phone"]');
    const emailInput = document.querySelector('input[name="email"]');

    if (nameInput) {
        nameInput.addEventListener("input", function () {
            this.value = this.value.replace(/[0-9]/g, "");
        });
    }

    if (phoneInput) {
        phoneInput.addEventListener("input", function () {
            this.value = this.value.replace(/[^0-9]/g, "").slice(0, 10);
        });
    }

    if (emailInput) {
        emailInput.addEventListener("input", function () {
            this.value = this.value.replace(/\s/g, "");
        });
    }
});
</script>

@endsection