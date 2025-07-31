<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Inertia\Inertia;

class PetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Gate::authorize('viewAny', Pet::class);

        $pets = Pet::with('owner')->get();

        return Inertia::render('Pets/Index', [
            'pets' => $pets,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('create', Pet::class);

        $owners = User::where('role_id', 3)->get(); // Customers only

        return Inertia::render('Pets/Create', [
            'owners' => $owners,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Gate::authorize('create', Pet::class);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'required|integer|min:0',
            'owner_id' => 'required|integer|exists:users,id',
        ]);

        Pet::create($validated);

        return redirect()->route('pets.index')->with('success', 'Pet created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pet = Pet::with('owner')->findOrFail($id);

        Gate::authorize('view', $pet);

        return Inertia::render('Pets/Show', [
            'pet' => $pet,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pet = Pet::findOrFail($id);

        Gate::authorize('update', $pet);

        $owners = User::where('role_id', 3)->get(); // Customers only

        return Inertia::render('Pets/Edit', [
            'pet' => $pet,
            'owners' => $owners,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $pet = Pet::findOrFail($id);

        Gate::authorize('update', $pet);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'species' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'required|integer|min:0',
            'owner_id' => 'required|integer|exists:users,id',
        ]);

        $pet->update($validated);

        return redirect()->route('pets.index')->with('success', 'Pet updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $pet = Pet::findOrFail($id);

        Gate::authorize('delete', $pet);

        $pet->delete();

        return redirect()->route('pets.index')->with('success', 'Pet deleted successfully.');
    }
}