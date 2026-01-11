<?php
namespace App\Http\Controllers;
use App\Models\Contract;
use App\Models\Building;
use App\Models\Payment;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_contracts' => Contract::count(),
            'active_contracts' => Contract::where('status', 'active')->count(),
            'total_buildings' => Building::count(),
            'pending_payments' => Payment::where('status', 'pending')->count(),
        ];
        
        return Inertia::render('Dashboard', ['stats' => $stats]);
    }
}