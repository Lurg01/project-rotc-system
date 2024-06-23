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
   /**
         * Update the user with the given ID in storage.
         *
         * @param  \Illuminate\Http\Request $request
         * @param mixed $student_attendance
         * @return \Illuminate\Http\Response
         */

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
           
            // $pltn = $request->platoon;
            // $smstr = $request->semester;

            // $student_data = DB::table('attendance_records')->get();

            $student_attendance = AttendanceRecordsResource::collection(AttendanceRecordsModel::query()
            // ->when($request->, fn($query) => $query->whereRelation('student', 'course_id', $request->course))
            // ->with(['student' => fn($query) => $query->with('course', 'platoon', 'user.avatar')])
            ->get());

            return DataTables::of($student_attendance)->addIndexColumn()->make(true);

            // $student_attendance = DB::table('attendance_records')->get();

            // return DataTables::of($student_attendance)->addIndexColumn()->addColumn('full_day', function ($data) {
            //     return $data->student . ' - ' . $data->student_id . ' - ' . $data->day_one . ' - ' . $data->day_two . ' - ' . $data->day_three . ' - ' . $data->day_four . ' - ' . $data->day_five . ' - ' .
            //         $data->day_six . ' - ' . $data->day_seven . ' - ' . $data->day_eight . ' - ' . $data->day_nine . ' - ' . $data->day_ten . ' - ' . $data->day_eleven . ' - ' .
            //         $data->day_twelve . ' - ' . $data->day_thirtheen . ' - ' . $data->day_fourtheen . ' - ' . $data->day_fiftheen . ' - ' . $data->total_points . ' - ' . $data->average. ' - ' . $data->percentage_record;
            // })->make(true);

            
            // $student_data = DB::table('attendance_records')->get();
            // return  DataTables::of($student_data)->addIndexColumn()->addColumn('full_day', function ($data) {
            //     return $data->student_id . ' - ' . $data->day_one . ' - ' . $data->day_two . ' - ' . $data->day_three . ' - ' . $data->day_four . ' - ' . $data->day_five . ' - ' .
            //         $data->day_six . ' - ' . $data->day_seven . ' - ' . $data->day_eight . ' - ' . $data->day_nine . ' - ' . $data->day_ten . ' - ' . $data->day_eleven . ' - ' .
            //         $data->day_twelve . ' - ' . $data->day_thirtheen . ' - ' . $data->day_fourtheen . ' - ' . $data->day_fiftheen;
            // })->make(true);

            
                // return $data->student_id . ' - ' . $data->day_one . ' - ' . $data->day_two . ' - ' . $data->day_three . ' - ' . $data->day_four . ' - ' . $data->day_five . ' - ' .
                //     $data->day_six . ' - ' . $data->day_seven . ' - ' . $data->day_eight . ' - ' . $data->day_nine . ' - ' . $data->day_ten . ' - ' . $data->day_eleven . ' - ' .
                //     $data->day_twelve . ' - ' . $data->day_thirtheen . ' - ' . $data->day_fourtheen . ' - ' . $data->day_fiftheen;


            // show all student by selected platoon

            // if ($request->platoon) {
            //         $students = StudentResource::collection(
            //             Student::query()
            //                 ->when($request->filled('platoon'), fn ($query) => $query->where('platoon_id', $pltn))
            //                 ->with('course', 'platoon', 'user.avatar', 'semesteryears')
            //                 ->get());

            //         // show all student by selected semester and platoon
            //         if ($request->semester) {
            //             $students = StudentResource::collection(
            //                 Student::query()
            //                     ->when($request->filled('platoon'), fn ($query) => $query->where('platoon_id', $request->platoon))
            //                     ->with('course', 'platoon', 'user.avatar', 'semesteryears')
            //                     ->whereHas('semesteryears', function ($query) use ($request) {
            //                         $query->where('semester', '=', $request->semester);
            //                     })
            //                     ->get());
            //             } 
                        
            //         if ($request->year) {
            //         // show all student by selected year
            //         $students = StudentResource::collection(
            //             Student::query()
            //                 ->when($request->filled('platoon'), fn ($query) => $query->where('platoon_id', $request->platoon))
            //                 ->with('course', 'platoon', 'user.avatar', 'semesteryears')
            //                 ->whereHas('semesteryears', function ($query) use ($request, $smstr) {
            //                     $query->where([
            //                         ['semester', '=', $smstr],
            //                         ['year', '=', $request->year],
            //                     ]);
            //                 })
            //                 ->get() );
            //          }

            // }  else if ($request->semester){
            //     // show all student by selected semester
            //     $students = StudentResource::collection(
            //         Student::query()
            //             ->when($request->filled('semesteryears'))
            //             ->with('course', 'platoon', 'user.avatar', 'semesteryears')
            //             ->whereHas('semesteryears', function ($query) use ($request) {
            //                 $query->where('semester', '=', $request->semester);
            //             })
            //             ->get());

            //         if ($request->year) {
            //         // show all student by selected year
            //         $students = StudentResource::collection(
            //             Student::query()
            //                 ->when($request->filled('semesteryears'))
            //                 ->with('course', 'platoon', 'user.avatar', 'semesteryears')
            //                 ->whereHas('semesteryears', function ($query) use ($request, $smstr) {
            //                     $query->where([
            //                         ['semester', '=', $smstr],
            //                         ['year', '=', $request->year],
            //                     ]);
            //                 })
            //                 ->get() );
            //          }



            // } else if ($request->year) {
            //     // show all student by selected year
            //     $students = StudentResource::collection(
            //         Student::query()
            //             ->when($request->filled('semesteryears'))
            //             ->with('course', 'platoon', 'user.avatar', 'semesteryears')
            //             ->whereHas('semesteryears', function ($query) use ($request) {
            //                 $query->where([
            //                     ['year', '=', $request->year],
            //                 ]);
            //             })
            //             ->get() );
            // }
            // else {
                // show all student by default
                // $students = AttendanceRecordsResource::collection(AttendanceRecordsModel::query()
                // ->with('course', 'platoon', 'user.avatar', 'semesteryears')
                // ->get());
                // return response()->json($students);
                // $students = StudentResource::collection(Student::query()
                // ->with('course', 'platoon', 'user.avatar', 'semesteryears')
                // ->get());
            // }


            // return DataTables::of($student_data) // get all teacher from the current active academic year
            //     ->addIndexColumn()
            //     ->addColumn('actions', function ($row) {
            //         $new_row = collect($row);
            //         $route_show = route('admin.students.show', $new_row['id']);
            //         $route_edit = route('admin.students.edit', $new_row['id']);
            //         // <a class='dropdown-item' href='$route_show'>View</a>
            //         $btn = "
            //             <div class='dropdown'>
            //                 <a class='btn btn-sm btn-icon-only text-light' href='#' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
            //                 <i class='fas fa-ellipsis-v'></i>
            //                 </a>
            //                 <div class='dropdown-menu dropdown-menu-right dropdown-menu-arrow'>

            //                     <a class='dropdown-item' href='$route_show'>View</a>
            //                     <a class='dropdown-item' href='$route_edit'>Edit</a>

            //                     <a class='dropdown-item' href='javascript:void(0)' onclick='c_destroy($new_row[id],`admin.students.destroy`,`.student_dt`)'>Delete</a>
            //                 </div>
            //             </div> ";
            //         return $btn;
            //     })
            //     ->rawColumns(['actions'])
            //     ->make(true);
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




        // $q = semesteryear::distinct('year')->pluck('year', 'id');
        // $sem = semesteryear::distinct('semester')->pluck('semester', 'id');
        // $arr = [];
        // $arr_sem = [];
        // foreach ($q as $key) {
        //     if (!in_array($key, $arr)) {
        //         array_push($arr, $key);
        //     }
        // }
        // foreach ($sem as $key) {
        //     if (!in_array($key, $arr_sem)) {
        //         array_push($arr_sem, $key);
        //     }
        // }
     




        // if (request()->ajax()) {
        //     if ($request->query('course') == "") {
        //         $student_data = DB::table('students')->leftJoin('courses', 'students.course_id', '=', 'courses.id')->get();
        //         return  DataTables::of($student_data)->addIndexColumn()->make(true);
        //     } else {
        //         $student_data = DB::table('students')->leftJoin('courses', 'students.course_id', '=', 'courses.id')->where('courses.id', '=', $request->query('course'))->get();
        //         return  DataTables::of($student_data)->addIndexColumn()->make(true);
        //     }
        // }

        // $data = DB::table('attendance_records')->get();
        // $course = DB::table('courses')->get();
        // $student_data = DB::table('students')->leftJoin('courses', 'students.course_id', '=', 'courses.id')->get();

        // return view('admin.attendance_records.index', [
        //     'platoons' => Platoon::pluck('name', 'id'),
        //     'years' => $arr,
        //     'semesters' => $arr_sem,
        // ]);
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
