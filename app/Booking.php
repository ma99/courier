<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{

    public function shipment()
    {
    	return $this->hasOne(Shipment::class);
    	
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'sender_id');
    }

}
