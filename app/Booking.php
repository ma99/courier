<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_ref', 'customer_id', 'home_delivery', 'receiving_address', 'shipment_info', 'items'
    ];

    protected $casts = [
        'shipment_info' => 'boolean',        
    ];

    public function setHomeDeliveryAttribute($value)
    {
        $this->attributes['home_delivery'] = ($value == true) ? 'Yes' : 'No'; 
    }  

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
