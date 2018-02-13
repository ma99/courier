<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
