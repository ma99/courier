<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//use App\City;
use App\Booking;
use App\Customer;
use App\Receiver;

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

   public function searchBookingByRef(Request $request)
   {
    $error = ['error' => 'Booking Not Found']; 
    $bookingInfo = [];

    $query = $request->input('q');    

    //$booking = Booking::where('booking_ref', $query)->first();
    $booking = Booking::where('booking_ref', $query)->with('receiver:booking_id,name,phone,address')->first();
    //$booking = Booking::where('booking_ref', $query)->with('receiver')->first();
    //return $booking;
    if (!$booking) {
        return $booking;
    }    

    $weight = 'N/A';
    $date = 'N/A';
    if ($booking->shipment_info) {              
     $weight = $booking->shipment->weight;
     $date = date("d-m-Y", strtotime($booking->shipment->date));
    } 

    $customer = $this->findCustomerById($booking->customer_id);
    $bookingInfo[] = ([
                'booking_ref' => $booking->booking_ref,
                //'date' => $booking->created_at->format('d-m-Y'),
                'date' => $date,                
                'items' => $booking->items,
                'customer_name' => $customer->name,
                'customer_phone' => $customer->phone,
                'customer_address' => $customer->address,
                'receiver_name' => $booking->receiver->name,
                'receiver_phone' => $booking->receiver->phone,
                'receiver_address' => $booking->receiver->address,
                //'items' =>
                'weight' => $weight,
             ]);

      
    //return $bookings->count() ? $bookings : $error;
    return $bookingInfo;
   }

   public function findCustomerById($id)
   {
     return Customer::find($id);
   }

   public function searchBookingByNameOrPhone(Request $request)
   {
    $error = ['error' => 'Booking Not Found']; 
    $bookingInfo = [];

    $query = $request->input('q');    

    $customer = Customer::where('name', $query)
                          ->orWhere('phone', $query)->first();

     if (!$customer) {
        return $customer;
    }   

    
    $customerId= $customer->id;

    $booking = $this->findBookingInfoByCustomerId($customerId);

    $weight = 'N/A';
    $date = 'N/A';
    if ($booking->shipment_info) {              
     $weight = $booking->shipment->weight;
     $date = date("d-m-Y", strtotime($booking->shipment->date));
    } 

    //return $bookings;

    $bookingInfo[] = ([
                'booking_ref' => $booking->booking_ref,
                //'date' => $booking->created_at->format('d-m-Y'),
                'date' => $date,                
                'items' => $booking->items,
                'customer_name' => $customer->name,
                'customer_phone' => $customer->phone,
                'customer_address' => $customer->address,
                'receiver_name' => $booking->receiver->name,
                'receiver_phone' => $booking->receiver->phone,
                'receiver_address' => $booking->receiver->address,
                //'items' =>
                'weight' => $weight,
             ]);

    return $bookingInfo;

   }

   public function findBookingInfoByCustomerId($id)
   {
       //return Booking::where('customer_id', $id)->first();    
       return Booking::where('customer_id', $id)->with('receiver:booking_id,name,phone,address')->first();    
      //$booking = Booking::where('booking_ref', $query)->with('receiver:booking_id,name,phone,address')->first();

   }
  
}
