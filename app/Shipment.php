<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    
	 protected $fillable = [
        'booking_id', 'date', 'weight', 'location',
    ];
	 //protected $dateFormat = 'd-m-Y';


    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
