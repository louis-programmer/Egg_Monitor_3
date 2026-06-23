<?php

namespace App\Http\Controllers;

use App\Models\Machine;
use Illuminate\Http\Request;

class MachineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
{
    $machines = Machine::orderBy('machine_type')
        ->orderBy('machine_name')
        ->get();

    return view('machines.index', compact('machines'));
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
        public function show($id)
            {
                $machine = Machine::with('batches.order')
                    ->findOrFail($id);

                $currentBatch = $machine->batches()
                    ->latest()
                    ->first();

                return view('machines.show', compact(
                    'machine',
                    'currentBatch'
                ));
            }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Machine $machine)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Machine $machine)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Machine $machine)
    {
        //
    }
}
