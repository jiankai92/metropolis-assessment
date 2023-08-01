<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VisitorCheckIns extends Model
{
    use HasFactory;

    protected $table = 'visitor_checkins';
    
    const TYPE = [
        'VEHICLE' => 'vehicle',
        'WALK_IN' => 'walk_in',
    ];

    public $fillable = ['name', 'type', 'contact_no', 'vehicle_reg_no', 'remarks', 'checkout_at'];
}
