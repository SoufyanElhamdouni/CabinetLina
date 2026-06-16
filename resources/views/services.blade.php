@extends('layouts.app')

@section('content')

<section class="services-page-hero">
    <div class="container">
        <p class="section-small-title">NOS PRESTATIONS</p>

        <h1>Des soins esthétiques présentés avec élégance</h1>

        <p>
            Chaque soin est présenté de manière détaillée pour vous guider dans votre choix. Vous y trouverez un descriptif complet , la durée de la prestation , ainsi que le tarif, avec la possibilité de réserver votre séance en un clic.
        </p>
    </div>
</section>

<section class="services-list-section">
    <div class="container">
        <div class="row g-4">
            @foreach($services as $service)
                <div class="col-md-6 col-lg-4">
                    <div class="service-card">
                        <div class="service-image-box">
                            <img src="{{ asset('images/' . ($service->image ?? 'service.png')) }}" 
                                alt="{{ $service->name }}">

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

@endsection