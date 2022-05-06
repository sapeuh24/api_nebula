<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleUser extends Model
{
    use HasFactory;

    protected $table = 'vehicle_users';

    public function tickets()
    {
        return $this->hasMany(Ticket::class, 'vehicle_plate', 'vehicle_plate');
    }
}