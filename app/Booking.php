<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function shipment()
    {
    	return $this->hasOne(Shipment::class);
    	
    }

    public function receiver()
    {
    	return $this->hasOne(Receiver::class);
    	
    }

}
