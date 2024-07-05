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
use App\Models\semesteryear;
use App\Models\Student;
use App\Http\Resources\Student\StudentResource;
use App\Models\Role;
use App\Http\Requests\Performance\PerformanceRequest;



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

            if ($request->semester) {
                $attendances = $this->getByAny($request);
    
            }
            elseif ($request->year) {
                $attendances = $this->getByAny($request);
        
            }
            else {
                $attendances = $this->getData($request);
            }

            return DataTables::of($attendances)->addIndexColumn()->make(true);
        }

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

        return view('platoon_leader.meritandemerit.index' , [
            'semesters' => $arr_sem,
            'years' => $arr,
        ]);
        
        // return view('platoon_leader.meritandemerit.index');  
    }

    private function getData($request)
    {
        $student_id = [];
        $data_all =StudentResource::collection(Student::with("acadgrade")
            ->with('course', 'platoon', 'user.avatar')
            ->whereBelongsTo(auth()->user()->student->platoon)
            ->whereRelation('user', 'role_id', Role::STUDENT)->get());
        foreach($data_all as $key => $value) {
            $student_id[$key] = $value->id;
        }

        $data = Performance::with("students")->orderBy('student_id')->get();
        $stud = [];
        $arr = [];
        $c = 0;
        $tottal_meritandpoints = 100;
        $total_demerits = 0;
        $lastItem = end($stud);

        foreach ($data as $key => $value) {
            if ($value->student_id == $student_id[$c]) { 
                if(!in_array($value->student_id,$stud)){
                    $stud[$c] = $value->student_id;
                    $c+=1;
                    $arr[$key]["student_id"] = $value->student_id;
                    $arr[$key]["student"] = $value->students->first_name." ".$value->students->last_name;
                    $data_merit = Performance::where([
                        ["student_id","=",$value->student_id],
                        ["type","=","merit"]
                        ])->sum('points');
                    $data_demerit = Performance::where([
                        ["student_id","=",$value->student_id],
                        ["type","=","demerit"]
                        ])->sum('points');

                    if ($data_demerit <= 0 ){
                        $data_demerit = 0;
                    }
                    if ($data_merit <= 0 ) {
                        $data_merit = 100;
                    }
                

                    if ($data_demerit > 0) {
                        $data_merit -= $data_demerit;             
                    }    


                    if ($data_merit >= 100) {
                        $data_merit = 100;
                    }
                 
                    if ($data_demerit >= 100) {
                        $data_demerit = 100;
                    }

                
                    $arr[$key]["demerits"] = $data_demerit;
                    $arr[$key]["merits"] = $data_merit;
                    $arr[$key]["total_points"] = $data_merit;
                    $percentage = $data_merit * 0.3;
                    $arr[$key]["percentage"] = $percentage;

                  
                }
            }
        
        }
        return $arr;
    }

    
    private function getByAny($request) {

        $student_id = 0;
        $data_all =StudentResource::collection(Student::with("acadgrade")
            ->with('course', 'platoon', 'user.avatar')
            ->whereBelongsTo(auth()->user()->student->platoon)
            ->whereRelation('user', 'role_id', Role::STUDENT)->get());
        foreach($data_all as $key => $value) {
            if ($value->semesteryears->semester == $request->semester) {
                $student_id = $value->id;
            }
            if ($value->semesteryears->year == $request->year) {
                $student_id = $value->id;
            }
        }
        
        $data = Performance::with("students")->orderBy('student_id')->get();
        $stud = [];
        $arr = [];
        $c = 0;
        
        if ($request->semester) {
            foreach ($data as $key => $value) {
                if ($value->student_id == $student_id) { 
                    if(!in_array($value->student_id,$stud)){
                        $arr[$key]["student_id"] = $value->student_id - 1;
                        $arr[$key]["student"] = $value->students->first_name." ".$value->students->last_name;
                        $stud[$c] = $value->student_id;
                        $c+=1;
                        $data_merit = Performance::where([
                            ["student_id","=",$value->student_id],
                            ["type","=","merit"]
                            ])->sum('points');
                        $data_demerit = Performance::where([
                            ["student_id","=",$value->student_id],
                            ["type","=","demerit"]
                            ])->sum('points');
                        if ($data_demerit < $data_merit || $data_demerit >= $data_merit) {
                            $data_demerit = $data_demerit - $data_merit;
                        }
                        elseif ($data_demerit > $data_merit || $data_demerit <= $data_merit) {
                            $data_merit = $data_merit + $data_demerit;
                        }
        
                        if ($data_merit >= 100 ) {
                            $data_merit = 100;
                        }elseif ($data_merit <= 0){
                            $data_merit = 0;
                        }
                        if ($data_demerit >= 100) {
                            $data_demerit = 100;
                        }elseif ($data_demerit <= 0){
                            $data_demerit = 0;
                        }
                        $arr[$key]["demerits"] = $data_demerit;
                        $arr[$key]["merits"] = $data_merit;
                        $arr[$key]["total_points"] = $data_merit;
                        $percentage = $data_merit * 0.3;
                        $arr[$key]["percentage"] = $percentage;                                   
                    }
                }
            }
        }
       

        if ($request->year) {
            foreach ($data as $key => $value) {
                if ($value->student_id == $student_id) { 
                    if(!in_array($value->student_id,$stud)){
                        $arr[$key]["student"] = $value->students->first_name." ".$value->students->last_name;
                        $arr[$key]["student_id"] = $value->student_id - 1;
                        $stud[$c] = $value->student_id;
                        $c+=1;
                        $data_merit = Performance::where([
                            ["student_id","=",$value->student_id],
                            ["type","=","merit"]
                            ])->sum('points');
                        $data_demerit = Performance::where([
                            ["student_id","=",$value->student_id],
                            ["type","=","demerit"]
                            ])->sum('points');
                        if ($data_demerit < $data_merit || $data_demerit >= $data_merit) {
                            $data_demerit = $data_demerit - $data_merit;
                        }
                        elseif ($data_demerit > $data_merit || $data_demerit <= $data_merit) {
                            $data_merit = $data_merit + $data_demerit;
                        }
        
                        if ($data_merit >= 100 ) {
                            $data_merit = 100;
                        }elseif ($data_merit <= 0){
                            $data_merit = 0;
                        }
                        if ($data_demerit >= 100) {
                            $data_demerit = 100;
                        }elseif ($data_demerit <= 0){
                            $data_demerit = 0;
                        }
                        $arr[$key]["demerits"] = $data_demerit;
                        $arr[$key]["merits"] = $data_merit;
                        $arr[$key]["total_points"] = $data_merit;
                        $percentage = $data_merit * 0.3;
                        $arr[$key]["percentage"] = $percentage;
                    }
                }
            } 
        }
        return $arr;
    }

    // public function store(PerformanceRequest $request)
    // {
    //     Performance::create($request->validated());

    //     return to_route('platoon_leader.meritandemerit.index')->with(['success' => 'Student Performance Record Added Successfully']);
    // }

}