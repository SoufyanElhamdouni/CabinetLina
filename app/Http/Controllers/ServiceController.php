<?php

namespace App\Http\Controllers;

use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('subServices')->get();

        return view('services', compact('services'));
    }
}