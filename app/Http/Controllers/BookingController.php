<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Pet;
use App\Models\Room;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Booking::class);

        $bookings = Booking::with(['pet', 'room', 'service'])->get();

        return Inertia::render('Bookings/Index', [
            'bookings' => $bookings,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Booking::class);

        $pets = Pet::all();
        $rooms = Room::all();
        $services = Service::all();

        return Inertia::render('Bookings/Create', [
            'pets' => $pets,
            'rooms' => $rooms,
            'services' => $services,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Booking::class);

        $validated = $request->validate([
            'pet_id' => 'required|integer|exists:pets,id',
            'room_id' => 'required|integer|exists:rooms,id',
            'service_id' => 'required|integer|exists:services,id',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'notes' => 'nullable|string|max:1000',
        ]);

        Booking::create($validated);

        return redirect()->route('bookings.index')->with('success', 'Booking created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = Booking::with(['pet', 'room', 'service'])->findOrFail($id);

        Gate::authorize('view', $booking);

        return Inertia::render('Bookings/Show', [
            'booking' => $booking,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $booking = Booking::findOrFail($id);

        Gate::authorize('update', $booking);

        $pets = Pet::all();
        $rooms = Room::all();
        $services = Service::all();

        return Inertia::render('Bookings/Edit', [
            'booking' => $booking,
            'pets' => $pets,
            'rooms' => $rooms,
            'services' => $services,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $booking = Booking::findOrFail($id);

        Gate::authorize('update', $booking);

        $validated = $request->validate([
            'pet_id' => 'required|integer|exists:pets,id',
            'room_id' => 'required|integer|exists:rooms,id',
            'service_id' => 'required|integer|exists:services,id',
            'start_date' => 'required|date|after:now',
            'end_date' => 'required|date|after:start_date',
            'notes' => 'nullable|string|max:1000',
        ]);

        $booking->update($validated);

        return redirect()->route('bookings.index')->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = Booking::findOrFail($id);

        Gate::authorize('delete', $booking);

        $booking->delete();

        return redirect()->route('bookings.index')->with('success', 'Booking deleted successfully.');
    }
}