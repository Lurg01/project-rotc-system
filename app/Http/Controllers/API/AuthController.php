<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Validator;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Mail;
use App\Mail\sendEmail;
use App\Models\Otp;
use Illuminate\Console\View\Components\Alert;

use App\Models\AttendanceRecords;
use App\Models\semesteryear;
use App\Models\AttendanceRecordsModel; 
use App\Http\Resources\AttendanceRecords\AttendanceRecordsResource;

class AuthController extends Controller
{

 public function requestOtp(Request $request)
 {
    $otp = rand(1000,9999);
    Log::info("otp = ".$otp);
    $user = Otp::where('email','=',$request->email)->update(['otp' => $otp]);


    if($user){
        // send otp in the email
        $subj = 'ROTC Students Performance Record Management and Monitoring System -OTP';
        $body = $otp;
        Mail::to($request->email)->send(new sendEmail($subj,$body));
        return response(["status" => 200, "message" => "OTP sent successfully"]);
    }else{
        return response(["status" => 401, 'message' => 'Invalid']);
    }
}

    public function verifyOtp(Request $request){
    
        $user  = Otp::where([['email','=',$request->email],['otp','=',$request->otp]])->first();

        if($user){
            auth()->login($user, true);
            Otp::where('email','=',$request->email)->update(['otp' => null]);
            $accessToken = auth()->user()->createToken('authToken')->accessToken;

            return response(["status" => 200, "message" => "Success", 'user' => auth()->user(), 'access_token' => $accessToken]);
        }
        else{
            return response(["status" => 401, 'message' => 'Invalid']);
        }
    }

    public function otp(Request $request)
    {   
        // dd(auth()->id());
        // session()->flush();
        $uid = Otp::where('userid', auth()->id())->first();
        // dd(session()->get('token'));
        if(session()->get('email')==null){
            session()->flush();
            return redirect('/login');
        }
        $otp = rand(1000,9999);
        $email = session()->get('email');
        if(!$uid){
            try {
                $create_otp = Otp::create([
                    'userid' => auth()->id(),
                    'otp' => $otp,
                    'email' => $email,
                    'status' => 0,
                ]);
            } catch (\Exception $e) {
                $request->session()->flush();
                return redirect('/login')->with('message', $email);
            }
            
        }else{
            Otp::where('userid', auth()->id())
            ->update([
                'otp' => $otp
                ]);
        }
        $uid = Otp::where('id', auth()->id())->first();
        $subj = 'ROTC Students Performance Record Management and Monitoring System -OTP';
        $body = $otp;
        Mail::to($email)->send(new sendEmail($subj,$body));
        $q = semesteryear::distinct('year')->pluck('year', 'id');
        $sem = semesteryear::distinct('semester')->pluck('semester', 'id');
        $arr = [];
        $arr_sem = [];
        foreach ($q as $key) {
            if (!in_array($key, $arr)) {
                array_push($arr, $key);
            }
        }
        foreach ($sem as $key) {
            if (!in_array($key, $arr_sem)) {
                array_push($arr_sem, $key);
            }
        }
        return view('auth.otp', [
            'years' => $arr,
            'semesters' => $arr_sem,
        ])->with('success', 'The OTP has been sent to your email.');


        // return view('auth.otp')->with('success', 'The OTP has been sent to your email.');
    }

    // public function register()
    // {
    //     return view('auth.register');
    // }
    
    public function attemptOtp(Request $request)
    {
        if(session()->get('email')==null){
            return redirect('/login');
        }

        $credentials = $request->only('otp');
        $uid = Otp::where('userid', auth()->id())->first();
        if($uid){
            if($uid->otp==$credentials['otp']){
                Otp::where('userid', auth()->id())
                ->update([
                    'status' => 1
                ]);  
                session()->forget('email');
                session()->forget('token');
                $this->log_activity(model: auth()->user(), event:'login', model_name: 'Account', model_property_name: auth()->user()->name, conjunction:'an');
                session()->put('is_otp', true);
                return match (auth()->user()->role->name) {
                    'admin' => to_route('admin.dashboard.index'),
                    'platoon_leader' => to_route('platoon_leader.attendances.index'),
                    'student' => to_route('student.attendances.index'),
                };
            }else{
                return redirect('/otp');
            }
        }
    }
}