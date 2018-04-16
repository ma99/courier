<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $fillable = [
        'booking_ref', 'customer_id', 'home_delivery', 
        'receiving_address', 'shipment_info', 'items', 
        'parcel_type', 'parcel_quantity'
    ];

    protected $casts = [
        'shipment_info' => 'boolean',        
    ];

    public function setHomeDeliveryAttribute($value)
    {
        $this->attributes['home_delivery'] = ($value == true) ? 'Yes' : 'No'; 
    }

     public function setItemsAttribute($value)
    {
        $this->attributes['items'] = serialize($value);
    }

    public function getItemsAttribute($value)
    {   
        return unserialize($value);
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
    	//return $this->hasOne('App\Receiver');
    	
    }

}
