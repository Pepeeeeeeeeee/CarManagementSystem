<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    protected $fillable = [
        'car_id',
        'name',
        'serial_number',
    ];
}
