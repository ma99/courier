<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    
   protected $request;

   public function __construct(Request $request)
   {
        $this->request = $request;  
   }

    public function index()
    {
      if (auth()->check()) {
        $user = auth()->user();
        return ($user->username == 'admin') ? 'true' : 'false';
       }
       return 'false';
    }
}
