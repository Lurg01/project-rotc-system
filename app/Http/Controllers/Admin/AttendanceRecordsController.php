<?php

namespace App\Http\Controllers\Admin;

use App\Models\Otp;
use App\Models\Attendance;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\Role;
use App\Models\Student;
use App\Models\AttendanceRecords;   
use App\Models\AttendanceRecordsModel; 
use App\Models\Platoon;
use App\Models\semesteryear;
use App\Http\Resources\AttendanceRecords\AttendanceRecordsResource;


use App\Models\Department;

use App\Services\UserService;


use App\Http\Requests\Student\StudentRequest;
use App\Http\Resources\Student\StudentResource;
use App\Http\Resources\Attendance\AttendanceResource;




class AttendanceRecordsController extends Controller
{

    public function index(Request $request)
    {

        $sdata = Otp::where('userid', auth()->id())->first();
        $request_data = $sdata["status"] ?? null;
        if ($request_data == null) {
            return redirect('/otp');
        } else {
            if ($sdata["status"] == 0) {
                return redirect('/otp');
            }
            // New Session Login still required OTP
            if (session()->get('is_otp') == null) {
                return redirect('/otp');
            }
        }

        

        if (request()->ajax()) {

            $student_attendance = AttendanceRecordsResource::collection(AttendanceRecordsModel::query()
            ->get());

            return DataTables::of($student_attendance)->addIndexColumn()->make(true);

        
          
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
        // return view('admin.attendance_records.index');
        return view('admin.attendance_records.index' , [
            'platoons' => Platoon::pluck('name', 'id'),
            'years' => $arr,
            'semesters' => $arr_sem,
        ]);


    }

    public function create(Request $data)
    {
      
        if (request()->ajax()) {
            $arr = [];
            $query = DB::table('students')->get();
            foreach ($query as $g => $data) {
                array_push($arr, $data);
            }
            foreach ($arr as $value) {
                $id = $value->id;
                $fullname = $value->first_name . " " . $value->middle_name . " " . $value->last_name;
                if (DB::table('attendance_records')->where('student_id', $id)->exists()) {
                } else {
                    $c = DB::table('attendances')->where("student_id", $id)->count();
                    $key = ["day_one", "day_two", "day_three", "day_four", "day_five", "day_six", "day_seven", "day_eight", "day_nine", "day_ten", "day_eleven", "day_twelve", "day_thirtheen", "day_fourtheen", "day_fiftheen"];
                    $attendance_arr = [];
                    for ($i = 0; $i < 15; $i++) {
                        if ($i < $c) {
                            $attendance_arr[$key[$i]] = 1;
                        } else {
                            $attendance_arr[$key[$i]] = 0;
                        }
                    }
                    $attendance_arr["student_id"] = $value->id;
                    $attendance_arr["new_stud_id"] = $value->id;
                    $attendance_arr["student"] = $fullname;
                    $attendance_arr["total_points"] = 0;
                    $attendance_arr["average"] = 0;
                    $attendance_arr["percentage_record"] = 0;
                    $send = DB::table('attendance_records')->insert(
                        $attendance_arr
                    );
                }

                $sdata =  DB::table('acadgrade')->where('student_id', '=', $id)->first();
                $checkdata = $sdata->id ?? null;
                if ($checkdata == null || $checkdata == '') {
                    $sdata = Student::where('id', $id)->first();
                    $course_id = $sdata["course_id"];
                    $scourse = Course::where('id', $course_id)->first();
                    $course_name = $scourse["abbreviation"];
                    DB::table('acadgrade')->insert([
                        'new_stud_id' => $id,
                        'student_id' => $id,
                        'student' => $fullname,
                        'course' => $course_name,
                        'acad' => '-',
                        'grade' => '-',
                        'remarks' => '-',
                    ]);
                }
            }
            return "true";
        }
        // return "false";
        // return view('platoon_leader.attendance_records.create');
    }

    public function records()
    {
        if (request()->ajax()) {
            $student_data = DB::table('attendance_records')->get();
            return  DataTables::of($student_data)->addIndexColumn()->addColumn('full_day', function ($data) {
                return $data->student_id . ' - ' . $data->day_one . ' - ' . $data->day_two . ' - ' . $data->day_three . ' - ' . $data->day_four . ' - ' . $data->day_five . ' - ' .
                    $data->day_six . ' - ' . $data->day_seven . ' - ' . $data->day_eight . ' - ' . $data->day_nine . ' - ' . $data->day_ten . ' - ' . $data->day_eleven . ' - ' .
                    $data->day_twelve . ' - ' . $data->day_thirtheen . ' - ' . $data->day_fourtheen . ' - ' . $data->day_fiftheen;
            })->make(true);
        }
        // $users = DB::table('students')->where('student_id',$id)->get();
        // return response()->json($users);


      
    }
}
