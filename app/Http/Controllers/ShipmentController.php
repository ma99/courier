<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Booking;
use App\Shipment;
use App\Receiver;


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
       $startDate = date("Y-m-d", strtotime($this->request->input('start_date')));
       $endDate = date("Y-m-d", strtotime($this->request->input('end_date')));
       $booking = Shipment::whereBetween('date', [$startDate, $endDate])->get();
       
       $totalCustomer = $booking->count('booking_id');
       $totalWeight = $booking->sum('weight');
       
       return response()->json([
            'total_customer' => $totalCustomer,            
            'total_weight' => round($totalWeight),            
        ]);

   }

}
