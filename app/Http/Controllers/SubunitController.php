<?php
namespace App\Http\Controllers;
use App\Models\Subunit;
use App\Models\Unit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SubunitController extends Controller
{
public function index(Request $request)
{
    $subunits = Subunit::with('unit.building')
        ->when($request->search, fn($q) => 
            $q->whereHas('unit.building', fn($q2) => 
                $q2->where('building_name', 'like', "%{$request->search}%")
            )
        )
        ->latest()
        ->paginate(15);
    return Inertia::render('Subunits/Index', ['subunits' => $subunits]);
}
    public function create()
    {
        $units = Unit::with('building')->get();
        return Inertia::render('Subunits/Create', ['units' => $units]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'subunit_no' => 'required|string',
            'subunit_type' => 'required|string',
            'area_sqft' => 'nullable|integer',
            'status' => 'required|string',
        ]);

        Subunit::create($validated);
        return redirect()->route('subunits.index');
    }

    public function edit(Subunit $subunit)
    {
        $units = Unit::with('building')->get();
        return Inertia::render('Subunits/Edit', ['subunit' => $subunit, 'units' => $units]);
    }

    public function update(Request $request, Subunit $subunit)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:units,id',
            'subunit_no' => 'required|string',
            'subunit_type' => 'required|string',
            'area_sqft' => 'nullable|integer',
            'status' => 'required|string',
        ]);

        $subunit->update($validated);
        return redirect()->route('subunits.index');
    }

    public function destroy(Subunit $subunit)
    {
        $subunit->delete();
        return redirect()->route('subunits.index');
    }
}