<?php
namespace App\Http\Controllers;
use App\Models\Payment;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $payments = Payment::with('contract.unit.building', 'contract.person')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->type, fn($q) => $q->where('payment_type', $request->type))
            ->latest()
            ->paginate(20);

        return Inertia::render('Payments/Index', ['payments' => $payments]);
    }
}