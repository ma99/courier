<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//use App\City;
use App\Booking;

class SearchBookingController extends Controller
{
   
   // protected $request;

   // public function __construct(Request $request)
   // {
   //      $this->request = $request;  
   // } 
   
   
   public function bookingList()
   {
    $error = ['error' => 'Booking Not Found']; 
    
    $bookings = Booking::where('shipment_info', false)->get();
    
    return $bookings->count() ? $bookings : $error;
   }

  
}
