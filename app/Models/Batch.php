<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{
    use HasFactory;

            protected $fillable = [
            'order_id',
            'machine_id',
            'machine_type',
            'batch_amount',
            'started_at',
            'day0_at',
            'day18_at',
            'day19_at',
            'day21_at',
            'survived_day18',
            'spoiled_day18',
            'survived_day21',
            'spoiled_day21',
            'status',
            'remarks',
            'current_day',
        ];


    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function machine()
    {
        return $this->belongsTo(Machine::class);
    }






}
