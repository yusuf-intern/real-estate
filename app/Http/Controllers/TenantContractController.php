<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\Unit;
use App\Models\Tenant;
use App\Models\Subunit;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TenantContractController extends Controller
{
    public function index(Request $request)
    {
        $contracts = Contract::with(['unit.building', 'person', 'payments', 'subunits'])
            ->where('contract_type', 'tenant')
            ->when($request->search, fn($q) => $q->whereHas('unit.building', fn($q2) => $q2->where('building_name', 'like', "%{$request->search}%")))
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(12);

        return Inertia::render('TenantContracts/Index', ['contracts' => $contracts]);
    }

    public function show(Contract $tenantContract)
    {
        $tenantContract->load(['unit.building.tenant', 'person', 'payments', 'subunits']);
        return Inertia::render('TenantContracts/Show', ['contract' => $tenantContract]);
    }

    public function destroy(Contract $tenantContract)
    {
        $tenantContract->delete();
        return redirect()->route('tenant-contracts.index');
    }

// app/Http/Controllers/tenantContractController.php - add these methods
public function create()
{
    $units = Unit::with('building')->get();
    $tenants = Tenant::all();
    $subunits = Subunit::all();
    
    return Inertia::render('TenantContracts/Create', [
        'units' => $units,
        'tenants' => $tenants,
        'subunits' => $subunits
    ]);
}

public function store(Request $request)
{
    $validated = $request->validate([
        'unit_id' => 'required|exists:units,id',
        'person_id' => 'required|exists:tenants,id',
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
    
    return redirect()->route('tenant-contracts.index');
}

public function renew(Contract $tenantContract)
{
    $units = Unit::with('building')->get();
    $tenants = Tenant::all();
    $subunits = Subunit::all();
    
    $renewData = [
        'unit_id' => $tenantContract->unit_id,
        'person_id' => $tenantContract->person_id,
        'ejari_no' => $tenantContract->ejari_no,
        'duration_months' => $tenantContract->duration_months,
        'total_amount' => $tenantContract->total_amount,
        'start_date' => $tenantContract->end_date->addDay()->format('Y-m-d'),
        'subunit_ids' => $tenantContract->subunits->pluck('id')->toArray()
    ];
    
    return Inertia::render('TenantContracts/Create', [
        'units' => $units,
        'tenants' => $tenants,
        'subunits' => $subunits,
        'renewData' => $renewData
    ]);
}
}