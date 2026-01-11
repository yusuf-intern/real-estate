<?php

namespace App\Http\Controllers;

use App\Models\Contract;
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
        $tenantContract->load(['unit.building.owner', 'person', 'payments', 'subunits']);
        return Inertia::render('TenantContracts/Show', ['contract' => $tenantContract]);
    }

    public function destroy(Contract $tenantContract)
    {
        $tenantContract->delete();
        return redirect()->route('tenant-contracts.index');
    }
}