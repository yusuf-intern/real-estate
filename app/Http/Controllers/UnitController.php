<?php
namespace App\Http\Controllers;
use App\Models\Unit;
use App\Models\Building;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UnitController extends Controller
{
    public function index()
    {
        $units = Unit::with('building')->latest()->paginate(15);
        return Inertia::render('Units/Index', ['units' => $units]);
    }

    public function create()
    {
        $buildings = Building::all();
        return Inertia::render('Units/Create', ['buildings' => $buildings]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'unit_no' => 'required|string',
            'floor_no' => 'nullable|string',
            'area_sqft' => 'nullable|integer',
            'assets' => 'nullable|array',
            'status' => 'required|string',
        ]);

        Unit::create($validated);
        return redirect()->route('units.index');
    }

    public function edit(Unit $unit)
    {
        $buildings = Building::all();
        return Inertia::render('Units/Edit', ['unit' => $unit, 'buildings' => $buildings]);
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'unit_no' => 'required|string',
            'floor_no' => 'nullable|string',
            'area_sqft' => 'nullable|integer',
            'assets' => 'nullable|array',
            'status' => 'required|string',
        ]);

        $unit->update($validated);
        return redirect()->route('units.index');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();
        return redirect()->route('units.index');
    }
}