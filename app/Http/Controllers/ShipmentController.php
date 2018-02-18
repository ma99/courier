<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Booking;
use App\Shipment;


class ShipmentController extends Controller
{
    protected $request;

   public function __construct(Request $request)
   {
        $this->request = $request;  
   }

   public function store()
   {
     
       	$bookingId = $this->request->input('booking_id'); 
        $shipmentDate = $this->request->input('date'); 
       	$totalWeight = $this->request->input('total_weight');
       	$receivingAddress = $this->request->input('receiving_address');

       	

     //   	$customer = Customer::updateOrCreate(
    	//     ['name' => $senderName, 'phone' => $senderPhone],
    	//     ['address' => $senderAddress]
    	// );
        $date = date("Y-m-d", strtotime($shipmentDate));

    	$shipment = Shipment::create([
    		'booking_id' => $bookingId,
    		'date' => $date,
    		'weight' => $totalWeight,
    		'location' => $receivingAddress,
    	]);

        $this->updateBooking($bookingId);
    	

    	return $shipment;

   }

   public function updateBooking($bookingId)
   {
       $booking = Booking::find($bookingId);
        $booking->shipment_info = true;
        $booking->save();
   }

}
