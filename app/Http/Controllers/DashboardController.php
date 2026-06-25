<?php

namespace App\Http\Controllers;

use App\Models\Machine;

class DashboardController extends Controller
{
    public function index()
    {
       $setters = Machine::with('batches.order.customer')
    ->where('machine_type', 'setter')
    ->orderBy('id')
    ->get();

$hatchers = Machine::with('batches.order.customer')
    ->where('machine_type', 'hatcher')
    ->orderBy('id')
    ->get();

        return view('dashboard.index', compact(
            'setters',
            'hatchers'
        ));
    }
}