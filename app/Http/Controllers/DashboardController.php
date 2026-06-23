<?php

namespace App\Http\Controllers;

use App\Models\Machine;

class DashboardController extends Controller
{
    public function index()
    {
        $setters = Machine::where('machine_type', 'setter')
            ->orderBy('id')
            ->get();

        $hatchers = Machine::where('machine_type', 'hatcher')
            ->orderBy('id')
            ->get();

        return view('dashboard.index', compact(
            'setters',
            'hatchers'
        ));
    }
}