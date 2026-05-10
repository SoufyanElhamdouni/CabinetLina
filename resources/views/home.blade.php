@extends('layouts.app')

@section('content')

<section class="home-hero">
    
    <div class="container">
        <div class="row align-items-center g-5">

            <div class="col-lg-6">
                <span class="hero-badge">✦ Centre esthétique premium à Tétouan</span>

                <h1 class="hero-title">
                    Cabinet Lina<br>Esthétique
                </h1>

                <p class="hero-text">
                    Une expérience beauté élégante et professionnelle pour réserver vos soins
                    laser diode, HydraFacial, visage, blanchiment dentaire en quelques étapes.
                </p>

                <div class="hero-buttons">
                    <a href="{{ url('/reservation') }}" class="btn btn-gold">Réserver maintenant</a>
                    <a href="{{ url('/services') }}" class="btn btn-white">Voir les services →</a>
                </div>

                <div class="hero-features">
                    <div class="mini-card">☆<span>Soins ciblés</span></div>
                    <div class="mini-card">☆<span>Ambiance luxe</span></div>
                    <div class="mini-card">☆<span>Suivi clair</span></div>
                </div>
            </div>

            <div class="col-lg-6">
                <img src="{{ asset('images/cabinet-lina-hero.jpg') }}" class="hero-image" alt="Cabinet Lina Esthétique">
            </div>

        </div>
    </div>
</section>

<section class="presentation-section">
    <div class="container text-center">
        <p class="section-small-title">PRÉSENTATION</p>
        <h2 class="section-title">Un cabinet pensé pour une beauté confiante</h2>
        <p class="section-description">
            Cabinet Lina Esthétique propose une sélection de soins modernes dans un cadre raffiné, avec une interface de réservation claire pensée pour le confort des clientes et la gestion administrative.
        </p>

        <div class="row g-4 mt-5">
            <div class="col-md-4">
                <div class="info-card">
                    <div class="info-icon"><i class="fa-solid fa-wand-magic-sparkles" style="color:#9b6a16; font-size:24px;"></i></div>
                    <h4>Protocoles modernes</h4>
                    <p>une expertise moderne avec des protocoles clairs et des soins personalisés.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-card">
                    <div class="info-icon">
                        <span class="fa-stack" style="font-size:12px; color:#9b6a16;">
                        <i class="fa-solid fa-shield fa-stack-2x"></i>
                        <i class="fa-solid fa-check fa-stack-1x" style="color:white;"></i>
                        </span>
                    </div>
                    <h4>Parcours rassurant</h4>
                    <p>Réservez votre séance en quelques secondes : simple, rapide et entièrement sécurisé.</p>
                </div>
            </div>

            <div class="col-md-4">
                <div class="info-card">
                    <div class="info-icon"><i class="fa-regular fa-gem" style="color:#9b6a16; font-size:24px;"></i></div>
                    <h4>Identité premium</h4>
                    <p>Un univers raffiné dédié à l'élégance féminine, où chaque détail est pensé pour votre bien-être.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="services-section" id="services">
    <div class="container">
        <div class="section-head">
            <div>
                <p class="section-small-title">SERVICES</p>
                <h2 class="section-title text-start">Les soins les plus demandés</h2>
                <p class="section-description text-start">
                    Aperçu des prestations disponibles à la réservation.
                </p>
            </div>

            <a href="{{ url('/services') }}" class="btn btn-white">Tous les services</a>
        </div>

        <div class="row g-4">
            @foreach($services as $service)
                <div class="col-md-4">
                    <div class="service-card">
                        <div class="service-image-box">
                            <img src="{{ asset('images/' . ($service->image ?? 'service.png')) }}" alt="{{ $service->name }}">
                            <span>✦ {{ $service->name }}</span>
                        </div>

                        <div class="service-content">
                            <h3>{{ $service->name }}</h3>
                            <p>{{ $service->description }}</p>

                            <div class="service-tags">
                                <small>⏱ {{ $service->duration_minutes }} min</small>

                                @if($service->subServices->count() > 0)
                                    <small>À partir de {{ number_format($service->subServices->min('price'), 0, ',', ' ') }} DH</small>
                                @endif
                            </div>

                            <a href="{{ url('/reservation?service='.$service->id) }}" class="btn btn-gold w-100">
                                Réserver ce soin →
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="why-section">
    <div class="container">
        <div class="row g-5 align-items-center">
            <div class="col-lg-5">
                <p class="section-small-title">POURQUOI NOUS CHOISIR</p>
                <h2 class="section-title text-start">Une expérience claire du premier clic au rendez-vous</h2>
                <p class="section-description text-start">
                Une interface épurée qui reflète notre soin du détail, facilitant chaque étape de votre prise de rendez-vous
                </p>
            </div>

            <div class="col-lg-7">
                <div class="row g-3">
                    <div class="col-md-6"><div class="why-card">Interface responsive desktop/mobile</div></div>
                    <div class="col-md-6"><div class="why-card">Cartes services avec durée et prix</div></div>
                    <div class="col-md-6"><div class="why-card">Tableaux admin simples à lire</div></div>
                    <div class="col-md-6"><div class="why-card">Gestion des disponibilités structurée</div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="contact-section">
    <div class="container">
        <div class="contact-box row">
            <div class="col-6">
                <p class="section-small-title">CONTACT</p>
                <h2>Réservez votre moment beauté</h2>
                <p>Besoin d'un conseil ou d'un rendez-vous ? Notre équipe est à votre écoute pour sublimer votre beauté.</p>
            </div>
            <div class="col-1"></div>
            <div class="col-5 contact-info">
                <a href="tel:+212678758595"><p><i class="fa-solid fa-phone" style="color:#9b6a16; font-size:15px;"></i> +212 678758595</p></a>
                <a href="https://www.instagram.com/cabinetlina.esthetique"><p><i class="fa-brands fa-instagram" style="color:#9b6a16; font-size:15px;"></i> cabinetlina.esthetique</p></a>
                <p><i class="fa-solid fa-location-dot" style="color:#9b6a16; font-size:15px;"></i> 3 LOT TAMUDIMO ET.4 BUREAU N°14 LOT AIN MELLOUL , TETOUAN</p>
                <a href="{{ url('/reservation') }}" class="btn btn-gold">Réserver maintenant</a>
            </div>
        </div>
    </div>
</section>

@endsection