<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

//use App\City;
use App\Item;

class SearchItemController extends Controller
{
   
   // protected $request;

   // public function __construct(Request $request)
   // {
   //      $this->request = $request;  
   // } 
   
   
   public function itemList()
   {
    $error = ['error' => 'Item Not Found']; 
    
    $items = Item::all();
    
    return $items->count() ? $items : $error;
   }

   public function itemsForPagination()
   {
    $error = ['error' => 'Item Not Found']; 
    
    $items = Item::paginate(5);
    return $items;
    //return $items->count() ? $items : $error;
   }

  
}
