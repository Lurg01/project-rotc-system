<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\Otp;

class LoginController extends Controller
{
  
    use AuthenticatesUsers;

   
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {    
      
         $credentials = $request->only('email', 'password');

         if(Auth::attempt($credentials) && $user->is_activated) 
         {
            $request->session()->regenerate();
            // if($user->hasRole('user')) {
            //    return redirect(route('user.dashboard.index'));
            // }

            if($user->hasRole('admin')) {
               return redirect(route('admin.dashboard.index'));
            }

            if($user->hasRole('platoon_leader')) {
         
               return redirect(route('platoon_leader.attendances.index'));
            }
            
            if($user->hasRole('student')) {
               return redirect(route('student.attendances.index'));
            }
 
          
         } 
         else 
         {

            $request->session()->flush();
            return redirect('/login')->with('message', 'Unauthorized User');

         }
    }
}
