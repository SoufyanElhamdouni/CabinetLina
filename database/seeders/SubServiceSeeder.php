<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;
use App\Models\SubService;

class SubServiceSeeder extends Seeder
{
    public function run(): void
    {
        SubService::query()->delete();

        $data = [
            'Épilation laser diode' => [
                ['name' => 'Visage complet', 'price' => 300, 'duration_minutes' => 45],
                ['name' => 'Duvet + menton', 'price' => 200, 'duration_minutes' => 30],
                ['name' => 'Aisselles', 'price' => 200, 'duration_minutes' => 30],
                ['name' => 'Demi-bras', 'price' => 250, 'duration_minutes' => 35],
                ['name' => 'Bras complet', 'price' => 400, 'duration_minutes' => 45],
                ['name' => 'Demi-jambes', 'price' => 400, 'duration_minutes' => 45],
                ['name' => 'Jambes complètes', 'price' => 700, 'duration_minutes' => 60],
                ['name' => 'Maillot intégral', 'price' => 500, 'duration_minutes' => 45],
                ['name' => 'Épilation corps complet — 1 séance', 'price' => 1000, 'duration_minutes' => 90],
                ['name' => 'Pack 6 séances épilation complète', 'price' => 4000, 'duration_minutes' => 90],
                ['name' => 'Corps complet — 10 séances', 'price' => 6000, 'duration_minutes' => 90],
                ['name' => 'Jambes complètes — 10 séances', 'price' => 2500, 'duration_minutes' => 60],
                ['name' => 'Bras complet — 10 séances', 'price' => 2000, 'duration_minutes' => 45],
                ['name' => 'Visage complet — 10 séances', 'price' => 1500, 'duration_minutes' => 45],
                ['name' => 'Aisselles — 10 séances', 'price' => 1800, 'duration_minutes' => 30],
            ],

            'Soins visage' => [
                ['name' => 'Soin visage basic', 'price' => 200, 'duration_minutes' => 45],
                ['name' => 'Soin lifting', 'price' => 300, 'duration_minutes' => 60],
                ['name' => 'Soin anti tache', 'price' => 300, 'duration_minutes' => 60],
                ['name' => 'Soin hydratant', 'price' => 250, 'duration_minutes' => 45],
                ['name' => 'Soin basic + masque lead', 'price' => 300, 'duration_minutes' => 60],
                ['name' => 'Soin éclat', 'price' => 300, 'duration_minutes' => 60],
                ['name' => 'Modelage', 'price' => 170, 'duration_minutes' => 30],
            ],

            'HydraFacial' => [
                ['name' => 'HydraFacial basic', 'price' => 300, 'duration_minutes' => 60],
                ['name' => 'Hydra Deluxe', 'price' => 500, 'duration_minutes' => 75],
                ['name' => 'HydraFacial Medical', 'price' => 700, 'duration_minutes' => 90],
            ],

            'Microneedling' => [
                ['name' => 'Microneedling visage', 'price' => 500, 'duration_minutes' => 60],
                ['name' => 'Microneedling cheveux', 'price' => 500, 'duration_minutes' => 60],
                ['name' => 'Micro + vitamine', 'price' => 650, 'duration_minutes' => 75],
                ['name' => 'Pack micro 3 séances', 'price' => 1300, 'duration_minutes' => 60],
            ],

            'Blanchiment dentaire' => [
                ['name' => '1 séance', 'price' => 300, 'duration_minutes' => 40],
                ['name' => '2 séances', 'price' => 500, 'duration_minutes' => 60],
            ],

            'Amincissement' => [
                ['name' => 'Amincissement ciblé', 'price' => 300, 'duration_minutes' => 45],
                ['name' => 'Drainage lymphatique', 'price' => 350, 'duration_minutes' => 50],
                ['name' => 'Pack minceur 5 séances', 'price' => 1200, 'duration_minutes' => 60],
            ],
        ];

        foreach ($data as $serviceName => $subServices) {
            $service = Service::where('name', $serviceName)->first();

            if ($service) {
                foreach ($subServices as $subService) {
                    SubService::create([
                        'service_id' => $service->id,
                        'name' => $subService['name'],
                        'description' => null,
                        'duration_minutes' => $subService['duration_minutes'],
                        'price' => $subService['price'],
                    ]);
                }
            }
        }
    }
}
