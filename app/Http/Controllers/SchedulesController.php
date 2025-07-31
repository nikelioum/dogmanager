<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class SchedulesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Schedule::class);

        $schedules = Schedule::with(['service', 'user'])->get();

        return Inertia::render('Schedules/Index', [
            'schedules' => $schedules,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Schedule::class);

        $services = Service::all();
        $users = User::whereIn('role_id', [1, 2])->get();

        return Inertia::render('Schedules/Create', [
            'services' => $services,
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Schedule::class);

        $validated = $request->validate([
            'service_id' => 'required|integer|exists:services,id',
            'user_id' => 'required|integer|exists:users,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'notes' => 'nullable|string|max:1000',
        ]);

        Schedule::create($validated);

        return redirect()->route('schedules.index')->with('success', 'Schedule created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $schedule = Schedule::with(['service', 'user'])->findOrFail($id);

        Gate::authorize('view', $schedule);

        return Inertia::render('Schedules/Show', [
            'schedule' => $schedule,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $schedule = Schedule::findOrFail($id);

        Gate::authorize('update', $schedule);

        $services = Service::all();
        $users = User::whereIn('role_id', [1, 2])->get();

        return Inertia::render('Schedules/Edit', [
            'schedule' => $schedule,
            'services' => $services,
            'users' => $users,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $schedule = Schedule::findOrFail($id);

        Gate::authorize('update', $schedule);

        $validated = $request->validate([
            'service_id' => 'required|integer|exists:services,id',
            'user_id' => 'required|integer|exists:users,id',
            'start_time' => 'required|date|after:now',
            'end_time' => 'required|date|after:start_time',
            'notes' => 'nullable|string|max:1000',
        ]);

        $schedule->update($validated);

        return redirect()->route('schedules.index')->with('success', 'Schedule updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $schedule = Schedule::findOrFail($id);

        Gate::authorize('delete', $schedule);

        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }
}