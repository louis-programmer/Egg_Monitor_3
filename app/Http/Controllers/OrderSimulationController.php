<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Batch;
use App\Models\Machine;
use App\Models\Setting;



class OrderSimulationController extends Controller
{



public function start($orderId)
{
    $order = Order::with('batches')->findOrFail($orderId);

    $order->update([
         'status' => 'running',
        'current_day' => 0,
        'simulation_status' => 'running',
        'started_at' => now(),
    ]);

    foreach ($order->batches as $batch) {
        $batch->update([
            'started_at' => now(),
            'day0_at' => now(),
            'status' => 'running',
        ]);
    }

    return back();
}


public function nextDay($orderId)
{

    $settings = Setting::first();

    $setterRate = $settings->preset_setter_survival_rate / 100;


    $order = Order::with('batches.machine')->findOrFail($orderId);

    if ($order->simulation_status !== 'running') {
        return back();
    }

    $order->increment('current_day');
        $order->refresh();
        $day = $order->current_day;

    foreach ($order->batches as $batch) {

        $batch->increment('current_day');

        $day = $order->current_day;

        // DAY MARKERS
            if ($day == 18) {

                $batch->update([
                    'day18_at' => now(),
                    'survived_day18' => (int) ($batch->batch_amount * $setterRate),
                    'spoiled_day18' => $batch->batch_amount
                        - (int) ($batch->batch_amount * $setterRate),
                    'status' => 'paused',
                ]);

                $order->update([
                    'state' => 'paused',
                    'simulation_status' => 'paused',
                ]);
            }

        if ($day == 19) {
            $batch->update([
                'day19_at' => now(),
            ]);
        }

        if ($day == 21) {
            $batch->update([
                'day21_at' => now(),
                'status' => 'completed',
                'survived_day21' => (int) ($batch->batch_amount * $setterRate),
                'spoiled_day21' => $batch->batch_amount - (int) ($batch->batch_amount * $setterRate),
            ]);

            // free machine
            $batch->machine->update([
                'is_vacant' => true,
                'status' => 'standby',
            ]);
        }
    }

    return back();
}



    public function day18($orderId)
    {
        $order = Order::findOrFail($orderId);
       # $order->update(['current_day' => 18]);
        $order->update([
            'current_day' => 18,
            'status' => 'waiting_transfer',
            'state' => 'paused',
            'simulation_status' => 'paused',
        ]);

        return $this->nextDay($orderId);
    }



        public function day21($orderId)
        {
            $order = Order::findOrFail($orderId);
            $order->update(['current_day' => 21]);

            return $this->nextDay($orderId);
        }



        public function transferToHatchers($orderId)
            {
                $order = Order::with('batches')->findOrFail($orderId);

                $order->update([
                    'state' => 'hatcher',
                ]);

                foreach ($order->batches as $batch) {

                    $batch->update([
                        'machine_type' => 'hatcher',
                        'status' => 'pending',
                    ]);
                }

                return back();
            }




}
