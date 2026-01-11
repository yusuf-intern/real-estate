<?php
namespace App\Http\Controllers;
use App\Models\Building;
use App\Models\Owner;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BuildingController extends Controller
{
    public function index()
    {
         $buildings = Building::with('owner')
        ->when($request->search, fn($q) => $q->where('building_name', 'like', "%{$request->search}%"))
        ->latest()
        ->paginate(15);
    return Inertia::render('Buildings/Index', ['buildings' => $buildings]);
    }

    public function create()
    {
        $owners = Owner::all();
        return Inertia::render('Buildings/Create', ['owners' => $owners]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'building_name' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'status' => 'required|string',
        ]);

        Building::create($validated);
        return redirect()->route('buildings.index');
    }

    public function edit(Building $building)
    {
        $owners = Owner::all();
        return Inertia::render('Buildings/Edit', ['building' => $building, 'owners' => $owners]);
    }

    public function update(Request $request, Building $building)
    {
        $validated = $request->validate([
            'owner_id' => 'required|exists:owners,id',
            'building_name' => 'required|string',
            'address' => 'required|string',
            'city' => 'required|string',
            'status' => 'required|string',
        ]);

        $building->update($validated);
        return redirect()->route('buildings.index');
    }

    public function destroy(Building $building)
    {
        $building->delete();
        return redirect()->route('buildings.index');
    }
}