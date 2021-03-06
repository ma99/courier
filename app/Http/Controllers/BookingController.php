<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Booking;
use App\Customer;
use App\Receiver;

class BookingController extends Controller
{
    protected $request;

   public function __construct(Request $request)
   {
        $this->middleware('auth');  
        $this->request = $request;  
   }

   public function store()
   {
    $bookingRef = $this->request->input('booking_ref'); 
    $items = $this->request->input('items'); 
    $parcelQuantity = $this->request->input('parcel_quantity'); 
   	$parcelType = $this->request->input('parcel_type'); 

   	$senderName = $this->request->input('sender.name'); 
   	$senderPhone = $this->request->input('sender.phone');
   	$senderAddress = $this->request->input('sender.address');

   	$receiverName = $this->request->input('receiver.name');
   	$receiverPhone = $this->request->input('receiver.phone');
   	$receiverAddress = $this->request->input('receiver.address');

   	$homeDelivery = $this->request->input('home_delivery');
   	$receivingAddress = $this->request->input('receiving_address');

   	$customer = Customer::updateOrCreate(
	    ['name' => $senderName, 'phone' => $senderPhone],
	    ['address' => $senderAddress]
	);

	$booking = Booking::create([
		'booking_ref' => $bookingRef,
    'items' => $items,
    'parcel_quantity' => $parcelQuantity,
    'parcel_type' => $parcelType,
		'customer_id' => $customer->id,
		'home_delivery' => $homeDelivery,
		'receiving_address' => $receivingAddress,
	]);

	$receiver = Receiver::create([
	  'booking_id' => $booking->id,
		'name' => $receiverName,
		'phone' => $receiverPhone,
		'address' => $receiverAddress,
	]);

	return $customer;

   }

}
