<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ['name' => 'Épilation laser diode', 'description' => 'Réduction durable des poils avec technologie diode, protocole confortable et adapté à chaque phototype.', 'duration_minutes' => 45, 'price' => null, 'image' => 'laser.png'],
            ['name' => 'HydraFacial', 'description' => 'Nettoyage profond, extraction douce et infusion d’actifs pour une peau lumineuse dès la première séance.', 'duration_minutes' => 60, 'price' => null, 'image' => 'hydrafacial.png'],
            ['name' => 'Microneedling', 'description' => 'Stimulation cutanée ciblée pour améliorer texture, marques, pores et qualité globale de la peau.', 'duration_minutes' => 50, 'price' => null, 'image' => 'microneedling.png'],
            ['name' => 'Soins visage', 'description' => 'Rituels personnalisés hydratants, purifiants ou anti-âge selon le diagnostic beauté de la peau.', 'duration_minutes' => 45, 'price' => null, 'image' => 'Soinsvisage.png'],
            ['name' => 'Amincissement', 'description' => 'Programmes corps avec suivi esthétique pour accompagner l’affinement et la tonicité de la silhouette.', 'duration_minutes' => 60, 'price' => null, 'image' => 'amincissement.png'],
            ['name' => 'Blanchiment dentaire', 'description' => 'Séance esthétique dédiée à l’éclat du sourire avec une expérience professionnelle et rassurante.', 'duration_minutes' => 40, 'price' => null, 'image' => 'blanchimentdentaire.png'],
        ];

        Service::query()->delete();
        foreach ($services as $service) {
            Service::create($service);
        }
    }
}