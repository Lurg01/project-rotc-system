<?php

namespace App\Http\Controllers\PlatoonLeader;
use App\Models\Otp;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Performance;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Resources\Attendance\AttendanceResource;

class MeritanddemeritController extends Controller
{
    public function index(Request $request)
    {
        $sdata = Otp::where('userid', auth()->id())->first();
        $request_data = $sdata["status"] ?? null;
        if($request_data==null){
            return redirect('/otp');
        }else{
            if($sdata["status"]==0){
                return redirect('/otp');
            }
            // New Session Login still required OTP
            if(session()->get('is_otp')==null){
                return redirect('/otp');
            }
        }
        if(request()->ajax())
        {
            $attendances = AttendanceResource::collection(
                Attendance::query()
                ->when(filled($request->query('date_started_at')) && filled($request->query('date_ended_at')), 
                    fn($query) => $query->whereBetween('created_at', [Carbon::parse($request->date_started_at)->startOfDay(), Carbon::parse($request->date_ended_at)->endOfDay()]))

                ->when(filled($request->query('date_started_at')) && blank($request->query('date_ended_at')), 
                    fn($query) => $query->whereDate('created_at', $request->date_started_at))

                ->when(filled($request->query('date_ended_at')) && blank($request->query('date_started_at')), 
                    fn($query) => $query->whereDate('date_ended_at', $request->date_ended_at ))

                ->when(blank($request->query('date_started_at')) && blank($request->query('date_ended_at')), 
                    fn($query) => $query->whereDate('created_at', now()))

                ->with('student')
                ->whereBelongsTo(auth()->user()->student)

                ->latest()
                ->get()
            );

            return DataTables::of($attendances)->addIndexColumn()->make(true);
        }
        
        return view('platoon_leader.meritandemerit.index');  
    }

    public function get()
    {
        $data = Performance::with("students")->orderBy('student_id')->get();
        $stud = [];
        $arr = [];
        $c = 0;
        for ($i=0; $i < count($data); $i++) { 
            if(!in_array($data[$i]->student_id,$stud)){
                $arr[$i]["student"] = $data[$i]->students->first_name." ".$data[$i]->students->last_name;
                $arr[$i]["student_id"] = $data[$i]->student_id;
                $stud[$c] = $data[$i]->student_id;
                $c+=1;
                $data_merit = Performance::where([
                    ["student_id","=",$data[$i]->student_id],
                    ["type","=","merit"]
                    ])->sum('points');
                $data_demerit = Performance::where([
                    ["student_id","=",$data[$i]->student_id],
                    ["type","=","demerit"]
                    ])->sum('points');
                $cal = $data_merit - $data_demerit;
                $cal = max($cal, 0);
                $arr[$i]["total_points"] = 100-$data_demerit;
                $cal = $cal / 15;
                $average = $cal * 100;
                $merit = 100-$data_demerit;
                $percentage = $merit * 0.3;
                $arr[$i]["percentage"] = $percentage;
                $arr[$i]["merits"] = 100-$data_demerit;
                $arr[$i]["demerits"] = $data_demerit;
            }
        }
        // get merits and demerits
        return DataTables::of($arr)->addIndexColumn()->make(true);
    }
}