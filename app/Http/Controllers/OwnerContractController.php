<?php

namespace App\Http\Controllers;

use App\Models\Contract;
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
}
