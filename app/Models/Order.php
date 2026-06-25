<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'order_amount',
        'order_buffer',
           'total_eggs', // ← ADD THIS
        'setter_survival_rate',
        'hatcher_survival_rate',
        'projected_hatched',
        'projected_spoilage',
        'actual_hatched',
        'actual_spoilage',
        'state',
        'status',
        'remarks',
        'started_at',

        'current_day',
         'simulation_status',
    ];




    public function batches()
        {
            return $this->hasMany(Batch::class);
        }





public function customer()
{
    return $this->belongsTo(Customer::class);
}



}