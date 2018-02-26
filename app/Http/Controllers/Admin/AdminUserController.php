<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

use App\User;



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
      $this->request->validate([
        '*.name' => 'required|string|max:255',
        '*.username' => 'required|max:25|unique:users',
        '*.email' => 'required|string|email|max:255|unique:users',
        '*.password' => 'required|string|min:6',
      ]);        

      $name = $this->request->input('user.name');
      $username = $this->request->input('user.username');
      $email= $this->request->input('user.email');
      $password = $this->request->input('user.password');

      User::create([
            'name' => $name,
            'username' => $username,
            'email' => $email,
            'password' => Hash::make($password),
        ]);


      return 'Success';
    }

    


}
