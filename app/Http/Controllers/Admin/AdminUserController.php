<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;



class AdminUserController extends Controller
{
    
   protected $request;

   public function __construct(Request $request)
   {
        $this->middleware(['auth', 'admin']);  
        $this->request = $request;
   }

    public function index()
    {      
      return auth()->user()->isAdministrator();
    }

    public function addNewUser()
    {
      return $this->request->user;
    }

    


}
