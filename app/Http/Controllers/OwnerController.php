<?php
namespace App\Http\Controllers;
use App\Models\Owner;
use Illuminate\Http\Request;
use Inertia\Inertia;

class OwnerController extends Controller
{
public function index(Request $request)
{
    $owners = Owner::when($request->search, fn($q) => 
            $q->where('name', 'like', "%{$request->search}%")
              ->orWhere('phone', 'like', "%{$request->search}%")
        )
        ->latest()
        ->paginate(15);
    return Inertia::render('Owners/Index', ['owners' => $owners]);
}

    public function create()
    {
        return Inertia::render('Owners/Create');
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

        Owner::create($validated);
        return redirect()->route('owners.index');
    }

    public function edit(Owner $owner)
    {
        return Inertia::render('Owners/Edit', ['owner' => $owner]);
    }

    public function update(Request $request, Owner $owner)
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

        $owner->update($validated);
        return redirect()->route('owners.index');
    }

    public function destroy(Owner $owner)
    {
        $owner->delete();
        return redirect()->route('owners.index');
    }
}