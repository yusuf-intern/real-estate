<?php
namespace App\Http\Controllers;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TenantController extends Controller
{
public function index(Request $request)
{
    $tenants = Tenant::when($request->search, fn($q) => 
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('phone', 'like', "%{$request->search}%")
        )
        ->latest()
        ->paginate(15);
    return Inertia::render('Tenants/Index', ['tenants' => $tenants]);
}
    public function create()
    {
        return Inertia::render('Tenants/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'required|string',
            'emirates_id' => 'nullable|string',
            'passport_no' => 'nullable|string',
            'nationality' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        Tenant::create($validated);
        return redirect()->route('tenants.index');
    }

    public function edit(Tenant $tenant)
    {
        return Inertia::render('Tenants/Edit', ['tenant' => $tenant]);
    }

    public function update(Request $request, Tenant $tenant)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'nullable|email',
            'phone' => 'required|string',
            'emirates_id' => 'nullable|string',
            'passport_no' => 'nullable|string',
            'nationality' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $tenant->update($validated);
        return redirect()->route('tenants.index');
    }

    public function destroy(Tenant $tenant)
    {
        $tenant->delete();
        return redirect()->route('tenants.index');
    }
}