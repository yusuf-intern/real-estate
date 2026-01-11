<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Unit;
use App\Models\Owner;
use App\Models\Subunit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OwnerContractController extends Controller
{
    public function index(Request $request)
    {
        $contracts = Contract::with(['unit.building', 'person', 'payments', 'subunits'])
            ->where('contract_type', 'owner')
            ->when($request->search, fn($q) => $q->whereHas('unit.building', fn($q2) => $q2->where('building_name', 'like', "%{$request->search}%")))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(12);

        return Inertia::render('OwnerContracts/Index', ['contracts' => $contracts]);
    }

    public function show(Contract $ownerContract)
    {
        $ownerContract->load(['unit.building.owner', 'person', 'payments', 'subunits']);
        return Inertia::render('OwnerContracts/Show', ['contract' => $ownerContract]);
    }

    public function destroy(Contract $ownerContract)
    {
        $ownerContract->delete();
        return redirect()->route('owner-contracts.index');
    }

   

// app/Http/Controllers/OwnerContractController.php - add these methods
public function create()
{
    $units = Unit::with('building')->get();
    $owners = Owner::all();
    $subunits = Subunit::all();
    
    return Inertia::render('OwnerContracts/Create', [
        'units' => $units,
        'owners' => $owners,
        'subunits' => $subunits
    ]);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'unit_id' => 'required|exists:units,id',
        'person_id' => 'required|exists:owners,id',
        'contract_type' => 'required',
        'contract_number' => 'required|unique:contracts',
        'ejari_no' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'duration_months' => 'required|integer',
        'total_amount' => 'required|numeric',
        'status' => 'required',
        'notes' => 'nullable',
        'subunit_ids' => 'nullable|array',
        'payments' => 'required|array'
    ]);

    $contract = Contract::create($validated);
    
    if ($request->subunit_ids) {
        $contract->subunits()->attach($request->subunit_ids);
    }
    
    foreach ($request->payments as $payment) {
        $contract->payments()->create($payment);
    }
    
    return redirect()->route('owner-contracts.index');
}

public function renew(Contract $ownerContract)
{
    $units = Unit::with('building')->get();
    $owners = Owner::all();
    $subunits = Subunit::all();
    
    $renewData = [
        'unit_id' => $ownerContract->unit_id,
        'person_id' => $ownerContract->person_id,
        'ejari_no' => $ownerContract->ejari_no,
        'duration_months' => $ownerContract->duration_months,
        'total_amount' => $ownerContract->total_amount,
        'start_date' => $ownerContract->end_date->addDay()->format('Y-m-d'),
        'subunit_ids' => $ownerContract->subunits->pluck('id')->toArray()
    ];
    
    return Inertia::render('OwnerContracts/Create', [
        'units' => $units,
        'owners' => $owners,
        'subunits' => $subunits,
        'renewData' => $renewData
    ]);
}
}
