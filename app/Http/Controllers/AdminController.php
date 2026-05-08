<?php

namespace App\Http\Controllers;
use App\Models\Reservation;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Models\Availability;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    public function dashboard()
    {
        $total = Reservation::count();
        $pending = Reservation::where('status', 'pending')->count();
        $accepted = Reservation::where('status', 'accepted')->count();
        $completed = Reservation::where('status', 'completed')->count();
        $revenue = Reservation::where('status', 'completed')
            ->with('subService')
            ->get()
            ->sum(function ($reservation) {
                return $reservation->subService->price ?? 0;
            });

        $reservations = Reservation::with('service')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'total',
            'pending',
            'accepted',
            'completed',
            'revenue',
            'reservations'
        ));
    }

    public function appointments()
{
    $reservations = Reservation::with(['service', 'subService'])->latest()->get();

    $services = Service::with('subServices')->get();

    return view('admin.appointments', compact('reservations', 'services'));
}

    public function services()
{
    $services = Service::latest()->get();
    return view('admin.services', compact('services'));
}

public function updateService(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'duration_minutes' => 'required|integer',
        'price' => 'nullable|numeric',
        'description' => 'required|string',
    ]);

    $service = Service::findOrFail($id);

    $service->update([
        'name' => $request->name,
        'duration_minutes' => $request->duration_minutes,
        'price' => $request->price,
        'description' => $request->description,
    ]);

    return back()->with('success', 'Service modifié avec succès.');
}

public function storeService(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'duration_minutes' => 'required|integer',
                'price' => 'nullable|numeric',
                'description' => 'required|string',
            ]);

            Service::create([
                'name' => $request->name,
                'duration_minutes' => $request->duration_minutes,
                'price' => $request->price,
                'description' => $request->description,
                'image' => 'service.png',
            ]);

            return back()->with('success', 'Service ajouté avec succès.');
        }

        public function deleteService($id)
        {
            Service::findOrFail($id)->delete();
            return back()->with('success', 'Service supprimé avec succès.');
        }

        public function availability()
{
    $availabilities = Availability::latest()->get();

    return view('admin.availability', compact('availabilities'));
}

public function storeAvailability(Request $request)
{
    $request->validate([
        'day_of_week' => 'required|string',
        'start_time' => 'required',
        'end_time' => 'required',
    ]);

    Availability::create([
        'day_of_week' => $request->day_of_week,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
    ]);

    return back()->with('success', 'Disponibilité ajoutée avec succès.');
}

public function deleteAvailability($id)
{
    Availability::findOrFail($id)->delete();

    return back()->with('success', 'Disponibilité supprimée avec succès.');
}

    public function updateStatus($id, $status)
    {
        $reservation = Reservation::findOrFail($id);

        if (!in_array($status, ['accepted', 'refused', 'cancelled', 'completed'])) {
            abort(404);
        }

        $reservation->update([
            'status' => $status
        ]);

        return back()->with('success', 'Statut modifié avec succès.');
    }

            public function users()
        {
            $users = User::latest()->get();
            return view('admin.users', compact('users'));
        }

        public function storeUser(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|min:6',
                'role' => 'required|in:super_admin,staff',
            ]);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);

            return back()->with('success', 'Utilisateur ajouté avec succès.');
        }
        
        public function storeAppointment(Request $request)
{
    $request->validate([
        'service_id' => 'required|exists:services,id',
        'sub_service_id' => 'nullable|exists:sub_services,id',
        'client_name' => 'required|string|max:255',
        'phone' => 'required|string|max:30',
        'email' => 'nullable|email|max:255',
        'reservation_date' => 'required|date',
        'reservation_time' => 'required',
    ]);

    $exists = Reservation::where('reservation_date', $request->reservation_date)
        ->where('reservation_time', $request->reservation_time)
        ->whereIn('status', ['pending', 'accepted'])
        ->exists();

    if ($exists) {
        return back()->withErrors([
            'reservation_time' => 'Ce créneau est déjà réservé.'
        ]);
    }

    Reservation::create([
        'service_id' => $request->service_id,
        'sub_service_id' => $request->sub_service_id,
        'client_name' => $request->client_name,
        'phone' => $request->phone,
        'email' => $request->email,
        'reservation_date' => $request->reservation_date,
        'reservation_time' => $request->reservation_time,
        'status' => 'accepted',
    ]);

    return back()->with('success', 'Rendez-vous ajouté avec succès.');
}
            public function deleteUser($id)
            {
                if (auth()->id() == $id) {
                    return back()->withErrors(['delete' => 'Vous ne pouvez pas supprimer votre propre compte.']);
                }

                User::findOrFail($id)->delete();

                return back()->with('success', 'Utilisateur supprimé avec succès.');
            }
}