<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    
   protected $request;

   public function __construct()
   {
        $this->middleware('auth');  
        //$this->request = $request;
   }

    public function index()
    {
      if (auth()->check()) {
        $user = auth()->user();
        return ($user->username == 'admin') ? 'true' : 'false';
       }
       return 'false';
    }

    public function showChangePasswordForm(){
        return view('auth.passwords.changepassword');
    }

    public function changePassword(Request $request){
        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
          // The passwords matches
          return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
         }
        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
          //Current password and new password are same
          return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
          $validatedData = $request->validate([
                  'current_password' => 'required',
                  'new_password' => 'required|string|min:6|confirmed',
          ]);
          //Change Password
          // $user = Auth::user();
          // $user->password = bcrypt($request->get('new-password'));
          // $user->save();
          $request->user()->fill([
            'password' => Hash::make($request->new_password)
          ])->save();
          return redirect()->back()->with("success","Password changed successfully !");
    
    }

}
