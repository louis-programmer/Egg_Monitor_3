<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
    'name',
    'address',
    'contact_person',
    'contact_number',
    'remarks',
    'color_code',

];
}
