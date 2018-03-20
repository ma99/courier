<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Booking;
use App\Shipment;
use App\Receiver;
use App\Customer;


class ShipmentController extends Controller
{
  protected $request;

   public function __construct(Request $request)
   {
        $this->middleware('auth');  
        $this->request = $request;  
   }

   public function store()
   {
     
       	$bookingId = $this->request->input('booking_id'); 
        $shipmentDate = $this->request->input('date'); 
       	$totalWeight = $this->request->input('total_weight');
       	$receivingAddress = $this->request->input('receiving_address');

        $date = date("Y-m-d", strtotime($shipmentDate));

    	$shipment = Shipment::create([
    		'booking_id' => $bookingId,
    		'date' => $date,
    		'weight' => round($totalWeight),
    		'location' => $receivingAddress,
    	]);

        $receiver = Receiver::where('booking_id', $bookingId)->first();

        $bookingRef = $this->updateBookingAndReturnRef($bookingId);

        return response()->json([
            'receiver_name' => strtoupper($receiver->name),
            'receiver_phone' => $receiver->phone,
            'receiver_address' => strtoupper($receiver->address),
            //'receiver_address' => strtoupper($receivingAddress),
            'total_weight' => round($totalWeight),
            'booking_ref' => $bookingRef
        ]);
   }

   public function updateBookingAndReturnRef($bookingId)
   {
       $booking = Booking::find($bookingId);
        $booking->shipment_info = true;
        $booking->save();
        return $booking->booking_ref;
   }

   public function search()
   {
       $startDate = date("Y-m-d H:i:s", strtotime($this->request->input('start_date')));
       $endDate = date("Y-m-d 23:59:59", strtotime($this->request->input('end_date')));
       
       $bookings = Booking::whereBetween('created_at', [$startDate, $endDate])->with('shipment:booking_id,weight')->get();      
       //return $bookings;
       //$date = $bookings[0]->created_at->toDateString();
       //$date = $bookings[0]->created_at->format('d-m-Y');
       //return $date;
       $totalCustomer = $bookings->count('customer_id');
       
       $totalWeight = 0;
       $bookingInfo = [];
       foreach ($bookings as $booking) {        
         $totalWeight = $totalWeight + $booking->shipment->weight;
         $customer = $this->findCustomerById($booking->customer_id);
         $bookingInfo[] = ([
            'date' => $booking->created_at->format('d-m-Y'),
            'items' => $booking->items,
            'customer_name' => $customer->name,
            'customer_phone' => $customer->phone,
            //'items' =>
            'weight' => $booking->shipment->weight,
         ]);
       }
       
       return response()->json([
            'total_customer' => $totalCustomer,            
            'total_weight' => round($totalWeight),
            'bookings' => $bookingInfo           
        ]);

   }

   public function findCustomerById($id)
   {
     return Customer::find($id);

   }

}
