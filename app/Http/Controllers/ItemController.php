<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Item;

class ItemController extends Controller
{
    public function destroy(Request $request)
    {
        $error = ['error' => 'No results found'];
        $itemId = $request->input('item_id');
        $item = Item::find($itemId);
        //$item = Item::where('id', $itemId)->first();
        if($item) {
            $item->delete();
            return 'success';            
        }
        return $error;
    }

    public function store(Request $request)
    {
    	$this->validate($request, [
            'item_name' => 'required',
            //'division_name' => 'required|max:50'
            //'code' => 'required|max:25',
        ]);
    	$itemName = $request->input('item_name');        

        Item::updateOrCreate(            
            ['name' => $itemName]            
        );
    	return 'successfully added';
    }
}
