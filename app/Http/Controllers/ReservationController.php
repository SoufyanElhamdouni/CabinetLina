<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Reservation;
use Illuminate\Http\Request;
use App\Models\Availability;
use Carbon\Carbon;

class ReservationController extends Controller
{
    public function create()
    {
        $services = Service::with('subServices')->get();

    return view('reservation', compact('services'));
    }

    public function availableSlots(Request $request)
{
    $request->validate([
        'service_id' => 'required|exists:services,id',
        'date' => 'required|date',
    ]);

    $service = Service::findOrFail($request->service_id);
    $date = Carbon::parse($request->date);

    $days = [
        'Monday' => 'Lundi',
        'Tuesday' => 'Mardi',
        'Wednesday' => 'Mercredi',
        'Thursday' => 'Jeudi',
        'Friday' => 'Vendredi',
        'Saturday' => 'Samedi',
        'Sunday' => 'Dimanche',
    ];

    $dayName = $days[$date->format('l')];

    $availabilities = Availability::where('day_of_week', $dayName)->get();

    $reservedTimes = Reservation::where('reservation_date', $request->date)
        ->whereIn('status', ['pending', 'accepted'])
        ->pluck('reservation_time')
        ->map(fn($time) => Carbon::parse($time)->format('H:i'))
        ->toArray();

    $slots = [];

    foreach ($availabilities as $availability) {
        $start = Carbon::parse($availability->start_time);
        $end = Carbon::parse($availability->end_time);

        while ($start->copy()->addMinutes($service->duration_minutes)->lte($end)) {
            $slot = $start->format('H:i');

            if (!in_array($slot, $reservedTimes)) {
                $slots[] = $slot;
            }

            $start->addMinutes(60);
        }
    }

    return response()->json($slots);
}

    public function store(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:services,id',
            'client_name' => 'required|string|max:255',
            'phone' => 'required|string|max:30',
            'email' => 'nullable|email|max:255',
            'reservation_date' => 'required|date',
            'reservation_time' => 'required',
            'sub_service_id' => 'nullable|exists:sub_services,id',
        ]);

        $exists = Reservation::where('reservation_date', $request->reservation_date)
    ->where('reservation_time', $request->reservation_time)
    ->whereIn('status', ['pending', 'accepted'])
    ->exists();

if ($exists) {
    return back()->withErrors([
        'reservation_time' => 'Ce créneau est déjà réservé.'
    ])->withInput();
}

        Reservation::create([
            'service_id' => $request->service_id,
            'client_name' => $request->client_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'reservation_date' => $request->reservation_date,
            'reservation_time' => $request->reservation_time,
            'status' => 'pending',
            'sub_service_id' => $request->sub_service_id,
        ]);

        return redirect('/reservation')->with('success', 'Votre rendez-vous a été enregistré avec succès.');
    }
}