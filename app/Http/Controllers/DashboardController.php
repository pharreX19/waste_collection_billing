<?php

namespace App\Http\Controllers;

use App\Models\Payable;
use App\Models\Property;
use Carbon\Carbon;
use Inertia\Inertia;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {

        $lastYear = Carbon::now()->subYear(1)->year;

        $properties = Property::whereYear('registration_date', '>=', $lastYear)
            ->selectRaw('YEAR(registration_date) as year, COUNT(id) as count')
            ->groupBy('year')
            ->get();


        $payables = Payable::whereYear('billed_period', '>=', Carbon::now()->subYear(1)->year)
            ->whereIn('state', ['pending', 'paid'])
            ->selectRaw('YEAR(billed_period) as year, state, COALESCE(SUM(amount), 0) as total_amount')
            ->groupBy('year', 'state')
            ->get()
            ->groupBy('state');

        $pending = $payables->get('pending', collect());
        $paid = $payables->get('paid', collect());

        return Inertia::render('Dashboard', [
            'properties' => $properties,
            'pending' => $pending,
            'paid' => $paid
        ]);
    }
}
