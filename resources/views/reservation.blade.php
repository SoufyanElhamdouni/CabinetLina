@extends('layouts.app')

@section('content')

<section class="booking-hero">
    <div class="container">
        <p class="section-small-title">RÉSERVATION</p>

        <h1>Réservez votre rendez-vous en quatre étapes</h1>

        <p>
            Prototype frontend clair: choix du soin, date,
            créneau disponible et informations cliente.
        </p>
    </div>
</section>

<section class="booking-section">
    <div class="container">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger">
                Remplissez tous les champs obligatoires.
            </div>
        @endif

        <div class="booking-steps">
            <div class="step-box"><span>1</span><h3>Service</h3></div>
            <div class="step-box"><span>2</span><h3>Sous-service</h3></div>
            <div class="step-box"><span>3</span><h3>Date</h3></div>
            <div class="step-box"><span>4</span><h3>Créneau</h3></div>
            <div class="step-box"><span>5</span><h3>Cliente</h3></div>
        </div>

        <form action="{{ url('/reservation') }}" method="POST" id="reservationForm">
            @csrf

            <input type="hidden" name="service_id" id="service_id">
            <input type="hidden" name="reservation_time" id="reservation_time">
            <input type="hidden" name="sub_service_id" id="sub_service_id">

            <div class="row g-4">

                {{-- LEFT --}}
                <div class="col-lg-8">

                    {{-- STEP 1 --}}
                    <div class="booking-card">
                        <h4>Étape 1 — Choisir un service</h4>

                        <div class="service-select">
                            @foreach($services as $service)
                                <button type="button"
                                        class="service-btn"
                                        data-id="{{ $service->id }}"
                                        data-name="{{ $service->name }}"
                                        data-duration="{{ $service->duration_minutes }}"
                                        data-price="{{ $service->price ? $service->price . ' DH' : 'À définir' }}">
                                    {{ $service->name }}<br>
                                    <span>{{ $service->duration_minutes }} min</span>
                                </button>
                            @endforeach
                        </div>
                    </div>

                    <div class="booking-card">
                        <h4>Étape 2 — Choisir un type de soin</h4>

                        <div class="sub-service-select" id="subServiceBox">
                            <p class="text-muted">Choisissez d’abord un service.</p>
                        </div>
                    </div>

                    {{-- STEP 2 --}}
                    <div class="booking-card">
                        <h4>Étape 2 — Choisir une date</h4>

                        <input type="date"
                               name="reservation_date"
                               id="reservation_date"
                               class="form-control"
                               required>
                    </div>

                    {{-- STEP 3 --}}
                    <div class="booking-card">
                        <h4>Étape 3 — Choisir un créneau</h4>

                        <div class="time-slots" id="timeSlots">
                            <p class="text-muted">Choisissez un service et une date.</p>
                        </div>
                    </div>

                    {{-- STEP 4 --}}
                    <div class="booking-card">
                        <h4>Étape 4 — Informations cliente</h4>

                        <div class="row g-3">
                            <div class="col-md-6">
                                <input 
                                    type="text" 
                                    name="client_name" 
                                    placeholder="Nom complet" 
                                    class="form-control"
                                    pattern="^[A-Za-zÀ-ÿ\s'-]+$"
                                    title="Le nom doit contenir uniquement des lettres."
                                    required
                                >
                            </div>

                            <div class="col-md-6">
                                <input 
                                    type="tel" 
                                    name="phone" 
                                    placeholder="Téléphone" 
                                    class="form-control"
                                    pattern="^[0-9]{10}$"
                                    maxlength="10"
                                    inputmode="numeric"
                                    title="Le téléphone doit contenir exactement 10 chiffres."
                                    required
                                >
                            </div>

                            <div class="col-12">
                                <input 
                                    type="email" 
                                    name="email" 
                                    placeholder="Email" 
                                    class="form-control"
                                    pattern="^[^\s@]+@[^\s@]+\.[^\s@]+$"
                                    title="Veuillez saisir un email valide sans espaces."
                                    required
                                >
                            </div>
                        </div>

                        <button type="submit" class="btn-confirm w-100 mt-4">
                            Confirmer le rendez-vous
                        </button>
                    </div>

                </div>

                {{-- RIGHT --}}
                <div class="col-lg-4">

                    <div class="booking-summary">
                        <h5>Résumé</h5>
                        <h3>Votre soin</h3>

                        <ul>
                            <li>
                                <span>Service</span>
                                <strong id="summary-service">--</strong>
                            </li>

                            <li>
                                <span>Durée</span>
                                <strong id="summary-duration">--</strong>
                            </li>

                            <li>
                                <span>Sous-service</span>
                                <strong id="summary-sub-service">--</strong>
                            </li>

                            <li>
                                <span>Prix</span>
                                <strong id="summary-price">--</strong>
                            </li>

                            <li>
                                <span>Date</span>
                                <strong id="summary-date">--</strong>
                            </li>

                            <li>
                                <span>Heure</span>
                                <strong id="summary-time">--</strong>
                            </li>
                        </ul>
                    </div>

                </div>

            </div>
        </form>

    </div>
</section>
<script>
    window.servicesData = @json($services);
</script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const nameInput = document.querySelector('input[name="client_name"]');
    const phoneInput = document.querySelector('input[name="phone"]');
    const emailInput = document.querySelector('input[name="email"]');

    nameInput.addEventListener("input", function () {
        this.value = this.value.replace(/[0-9]/g, "");
    });

    phoneInput.addEventListener("input", function () {
        this.value = this.value.replace(/[^0-9]/g, "").slice(0, 10);
    });

    emailInput.addEventListener("input", function () {
        this.value = this.value.replace(/\s/g, "");
    });
});
</script>

@endsection