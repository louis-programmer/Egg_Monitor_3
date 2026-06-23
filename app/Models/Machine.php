<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $fillable = [
        'machine_name',
        'machine_type',
        'brand',
        'is_vacant',
        'is_active',
        'status',
        'maximum_load',
        'minimum_load',
        'available_on',
    ];


    public function batches()
        {
            return $this->hasMany(Batch::class);
        }


}