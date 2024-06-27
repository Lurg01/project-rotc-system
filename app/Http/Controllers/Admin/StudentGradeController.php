<?php

namespace App\Http\Controllers\Admin;

use App\Models\Otp;
use App\Models\Role;
use App\Models\Course;
use App\Models\Platoon;
use App\Models\Student;
use App\Models\Attendance;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Services\UserService;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\Student\StudentRequest;
use App\Http\Resources\Student\StudentResource;
use App\Http\Resources\Attendance\AttendanceResource;
use Illuminate\Support\Facades\DB;
use App\Models\Performance;

use App\Models\AttendanceRecords;
use App\Models\semesteryear;
use App\Models\AttendanceRecordsModel; 
use App\Http\Resources\AttendanceRecords\AttendanceRecordsResource;


class StudentGradeController extends Controller
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

        if(request()->ajax()) {

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

        return view('admin.studentsgrades.index' , [
            'platoons' => Platoon::pluck('name', 'id'),
            'years' => $arr,
            'semesters' => $arr_sem,
        ]);
        
    }

    public function create(Request $data)
    {
        if (request()->ajax()) {
            $stud_id = $data->query('student_id');
            $attendance = $data->query('attendance');
            $aptitude = $data->query('aptitude');
            $acad = $data->query('acad');
            $grade = (int)$attendance + (int)$aptitude + (int)$acad;
            $sdata = Student::where('id', $stud_id)->first();
            $student = $sdata["first_name"] . " " . $sdata["middle_name"] . " " . $sdata["last_name"];
            $course_id = $sdata["course_id"];
            $scourse = Course::where('id', $course_id)->first();
            $course_name = $scourse["abbreviation"];
            $remarks = "1";
            if ((int)$grade >= 75) {
                $remarks = "0";
            }
            $a = [
                'student' => $student,
                'course' => $course_name,
                'acad' => $acad,
                'grade' => $grade,
                'remarks' => $remarks,
            ];

            DB::table('acadgrade')->where('student_id', $stud_id)->update($a);
            $data_all = DB::table('acadgrade')->get();
            for ($i = 0; $i < count($data_all); $i++) {
                $fetch_attendance = DB::table('attendance_records')->where("student_id", "=", $data_all[$i]->student_id)->first();
                $c = (int)$fetch_attendance->day_one + (int)$fetch_attendance->day_two + (int)$fetch_attendance->day_three
                    + (int)$fetch_attendance->day_four + (int)$fetch_attendance->day_five + (int)$fetch_attendance->day_six
                    + (int)$fetch_attendance->day_seven + (int)$fetch_attendance->day_eight + (int)$fetch_attendance->day_nine
                    + (int)$fetch_attendance->day_ten + (int)$fetch_attendance->day_eleven + (int)$fetch_attendance->day_twelve
                    + (int)$fetch_attendance->day_thirtheen + (int)$fetch_attendance->day_fourtheen + (int)$fetch_attendance->day_fiftheen;
                $cal = $c / 15;
                $avg = $cal * 100;
                $attend = $avg * 0.3;
                $data_all[$i]->attendance = $attend;
                $fetch_sum_demerit =  Performance::where([
                    ["student_id", "=", $data_all[$i]->student_id],
                    ["type", "=", "demerit"]
                ])->sum('points');
                $total_points = 100 - (int)$fetch_sum_demerit;
                if ($total_points <= 0) {
                    $total_points = 0;
                }
                $aptitude = (int)$total_points * 0.3;
                $data_all[$i]->aptitude = $aptitude;
            }
            return  DataTables::of($data_all)->addIndexColumn()->make(true);
        }
    }

    public function store(Request $request)
    {
    }

    public function show(Request $request)
    {
        if (request()->ajax()) {
            $data_all = Student::with('acadgrade')->get();
            for ($i = 0; $i < count($data_all); $i++) {
                $fetch_attendance = DB::table('attendance_records')->where("student_id", "=", $data_all[$i]->student_id)->first();
                $c = 0;
                if ($fetch_attendance) {
                    $c = (int)$fetch_attendance->day_one + (int)$fetch_attendance->day_two + (int)$fetch_attendance->day_three
                        + (int)$fetch_attendance->day_four + (int)$fetch_attendance->day_five + (int)$fetch_attendance->day_six
                        + (int)$fetch_attendance->day_seven + (int)$fetch_attendance->day_eight + (int)$fetch_attendance->day_nine
                        + (int)$fetch_attendance->day_ten + (int)$fetch_attendance->day_eleven + (int)$fetch_attendance->day_twelve
                        + (int)$fetch_attendance->day_thirtheen + (int)$fetch_attendance->day_fourtheen + (int)$fetch_attendance->day_fiftheen;
                }
                $cal = $c / 15;
                $avg = $cal * 100;
                $attend = $avg * 0.3;
                $data_all[$i]->attendance = $attend;
                $fetch_sum_demerit =  Performance::where([
                    ["student_id", "=", $data_all[$i]->student_id],
                    ["type", "=", "demerit"]
                ])->sum('points');
                $total_points = 100 - (int)$fetch_sum_demerit;
                if ($total_points <= 0) {
                    $total_points = 0;
                }
                $aptitude = (int)$total_points * 0.3;
                $data_all[$i]->aptitude = $aptitude;
            }
            return  DataTables::of($data_all)->addIndexColumn()->make(true);
        }
    }

    public function edit(Request $request)
    {
    }

    public function update(Request $request)
    {
    }

    public function destroy(Request $request)
    {
    }
}
