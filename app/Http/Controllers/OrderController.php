<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Customer;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Models\Machine;
use App\Models\Batch;


class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::latest()->get();
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        $customers = Customer::all();
        $settings = Setting::first();

        return view('orders.create', compact('customers', 'settings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'order_amount' => 'required|integer|min:1',
        ]);

        $settings = Setting::first();

        $buffer = $settings->preset_order_buffer;

       $total = (int) ceil(
            $request->order_amount +
            ($request->order_amount * ($buffer / 100))
        );

        $order = Order::create([
            'customer_id' => $request->customer_id,
            'order_amount' => $request->order_amount,
            'order_buffer' => $buffer,
              'total_eggs' => $total,
            'setter_survival_rate' => $settings->preset_setter_survival_rate,
            'hatcher_survival_rate' => $settings->preset_hatcher_survival_rate,
            'status' => 'pending',
        ]);

        $this->generateBatches($order);

        return redirect()->route('orders.index');
    }


        private function generateBatches($order)
        {
            $remaining = $order->total_eggs;

            $machines = Machine::where('machine_type', 'setter')
                ->where('is_active', true)
                ->where('is_vacant', true)
                ->orderBy('id')
                ->get();

            foreach ($machines as $machine) {

                if ($remaining <= 0) {
                    break;
                }

                $capacity = $machine->maximum_load;

                $allocated = min($capacity, $remaining);

                Batch::create([
                    'order_id' => $order->id,
                    'machine_id' => $machine->id,
                    'machine_type' => 'setter',
                    'batch_amount' => $allocated,
                    'status' => 'pending',
                ]);

                $machine->update([
                        'is_vacant' => false,
                        'status' => 'processing',
                    ]);

                $remaining -= $allocated;
            }

            if ($remaining > 0) {
                throw new \Exception(
                    "Not enough available setter machine capacity. Remaining eggs: {$remaining}"
                );
            }


        }


public function show($id)
{
    $order = Order::with('batches.machine')->findOrFail($id);

    return view('orders.show', compact('order'));
}


}