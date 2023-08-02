<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
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

    protected function createdAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => Carbon::parse($value)->diffForHumans(),
        );
    }

    protected function checkoutAt(): Attribute
    {
        return Attribute::make(
            get: fn($value) => isset($value) ? Carbon::parse($value)->diffForHumans() : $value,
        );
    }
}
