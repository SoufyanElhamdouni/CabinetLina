<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AdminController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Service;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {

    $services = Service::with('subServices')->take(3)->get();
    return view('home', compact('services'));
});

Route::get('/services', [ServiceController::class, 'index']);

Route::get('/reservation', [ReservationController::class, 'create']);
Route::post('/reservation', [ReservationController::class, 'store']);

Route::get('/available-slots', [ReservationController::class, 'availableSlots']);




/*
|--------------------------------------------------------------------------
| Admin Login
|--------------------------------------------------------------------------
*/

Route::get('/admin/login', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'staff') {
            return redirect('/admin/appointments');
        }

        return redirect('/admin/dashboard');
    }

    return view('admin.login');
})->name('login');

Route::post('/admin/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        if (Auth::user()->role === 'staff') {
            return redirect('/admin/appointments');
        }

        return redirect('/admin/dashboard');
    }

    return back()->withErrors([
        'email' => 'Email ou mot de passe incorrect.',
    ]);
});

Route::post('/admin/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/admin/login');
});


/*
|--------------------------------------------------------------------------
| Admin Routes Protected
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    // Staff + Super Admin
    Route::get('/admin/appointments', [AdminController::class, 'appointments']);
    Route::post('/admin/appointments/store', [AdminController::class, 'storeAppointment']);
    Route::post('/admin/appointments/{id}/{status}', [AdminController::class, 'updateStatus']);

    // Super Admin only
    Route::middleware('superadmin')->group(function () {

        Route::get('/admin/dashboard', [AdminController::class, 'dashboard']);

        Route::get('/admin/services', [AdminController::class, 'services']);
        Route::post('/admin/services', [AdminController::class, 'storeService']);
        Route::put('/admin/services/{id}', [AdminController::class, 'updateService']);
        Route::delete('/admin/services/{id}', [AdminController::class, 'deleteService']);

        Route::get('/admin/availability', [AdminController::class, 'availability']);
        Route::post('/admin/availability', [AdminController::class, 'storeAvailability']);
        Route::delete('/admin/availability/{id}', [AdminController::class, 'deleteAvailability']);

        Route::get('/admin/users', [AdminController::class, 'users']);
        Route::post('/admin/users', [AdminController::class, 'storeUser']);

        Route::delete('/admin/users/{id}', [AdminController::class, 'deleteUser']);
    });
});