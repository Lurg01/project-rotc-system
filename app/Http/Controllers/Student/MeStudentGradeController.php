<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;
use App\Models\Performance;
use App\Models\User;
use App\Models\Otp;
use App\Http\Resources\AttendanceRecords\AttendanceRecordsResource;
use App\Models\AttendanceRecordsModel; 



class MeStudentGradeController extends Controller
{
    public function index(Request $data)
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
        return view('student.studentgrade.index');
    }

    public function show(Request $data)
    {
        $student_attendance = AttendanceRecordsResource::collection(AttendanceRecordsModel::query()
            ->with('students')
            ->get());
        $arr = [];
        foreach ($student_attendance as $key =>$value) {
            if ($value->day_fiftheen != 0) {
                $sid = User::where('id', auth()->id())->first();
                $data_all = DB::table('acadgrade')->where("student_id", "=", $sid->student_id)->first();
                $fetch_attendance = DB::table('attendance_records')->where("student_id", "=", $sid->student_id)->first();
                $c = (int)$fetch_attendance->day_one + (int)$fetch_attendance->day_two + (int)$fetch_attendance->day_three
                    + (int)$fetch_attendance->day_four + (int)$fetch_attendance->day_five + (int)$fetch_attendance->day_six
                    + (int)$fetch_attendance->day_seven + (int)$fetch_attendance->day_eight + (int)$fetch_attendance->day_nine
                    + (int)$fetch_attendance->day_ten + (int)$fetch_attendance->day_eleven + (int)$fetch_attendance->day_twelve
                    + (int)$fetch_attendance->day_thirtheen + (int)$fetch_attendance->day_fourtheen + (int)$fetch_attendance->day_fiftheen;
                $cal = $c / 15;
                $avg = $cal * 100;
                $attend = $avg * 0.3;
                $data_all->attendance = $attend;
                $fetch_sum_demerit = Performance::where([
                    ["student_id", "=", $sid->student_id],
                    ["type", "=", "demerit"]
                ])->sum('points');
                $total_points = 100 - (int)$fetch_sum_demerit;
                if ($total_points <= 0) {
                    $total_points = 0;
                }
                $aptitude = (int)$total_points * 0.3;
                $data_all->aptitude = $aptitude;
                $data_all->id = 1;
            
                $arr[0] = $data_all;
            }
        }
        
        return DataTables::of($arr)->addIndexColumn()->make(true);
    }
}
