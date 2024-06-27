<?php

namespace App\Http\Controllers\Admin;

use App\Models\Otp;
use Carbon\Carbon;
use App\Models\Attendance;
use App\Models\Performance;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use App\Http\Resources\Attendance\AttendanceResource;
use App\Models\Student;

use App\Models\Course;
use Illuminate\Support\Facades\DB;
use App\Models\AttendanceRecords;
use App\Models\Platoon;
use App\Models\semesteryear;
use App\Models\AttendanceRecordsModel; 
use App\Http\Resources\AttendanceRecords\AttendanceRecordsResource;


class MeritanddemeritController extends Controller
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
            $attendances = AttendanceResource::collection(
                Attendance::query()
                    ->when(
                        filled($request->query('date_started_at')) && filled($request->query('date_ended_at')),
                        fn ($query) => $query->whereBetween('created_at', [Carbon::parse($request->date_started_at)->startOfDay(), Carbon::parse($request->date_ended_at)->endOfDay()])
                    )

                    ->when(
                        filled($request->query('date_started_at')) && blank($request->query('date_ended_at')),
                        fn ($query) => $query->whereDate('created_at', $request->date_started_at)
                    )

                    ->when(
                        filled($request->query('date_ended_at')) && blank($request->query('date_started_at')),
                        fn ($query) => $query->whereDate('date_ended_at', $request->date_ended_at)
                    )

                    ->when(
                        blank($request->query('date_started_at')) && blank($request->query('date_ended_at')),
                        fn ($query) => $query->whereDate('created_at', now())
                    )

                    ->with('student')
                    ->whereBelongsTo(auth()->user()->student)

                    ->latest()
                    ->get()
            );

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

        return view('admin.meritandemerit.index' , [
            'platoons' => Platoon::pluck('name', 'id'),
            'years' => $arr,
            'semesters' => $arr_sem,
        ]);
        
    }



    public function get()
    {
    
        $data = Student::with("performances")->get();
        $stud = [];
        $arr = [];
        foreach ($data as $key => $value) {
            $arr[$key]["student"] = $value->first_name . " " . $value->last_name;
            $arr[$key]["student_id"] = $value->id;
            $stud[$key]["student_id"] = $value->id;
            $data_merit = Performance::where([
                ["student_id", "=", $value->id],
                ["type", "=", "merit"]
            ])->sum('points');
            $data_demerit = Performance::where([
                ["student_id", "=", $value->id],
                ["type", "=", "demerit"]
            ])->sum('points');
            $cal = $data_merit - $data_demerit;
            $cal = max($cal, 0);
            $arr[$key]["total_points"] = 100 - $data_demerit;
            $cal = $cal / 15;
            $average = $cal * 100;
            $merit = 100 - $data_demerit;
            $percentage = $merit * 0.3;
            $arr[$key]["average"] = $average;
            $arr[$key]["percentage"] = $percentage;
            $arr[$key]["merits"] = 100 - $data_demerit;
            $arr[$key]["demerits"] = $data_demerit;
        }

        return DataTables::of($arr)->addIndexColumn()->make(true);

        
    }

    public function filter(Request $request)
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
            
            $data = Student::with("performances")->get();
            $stud = [];
            $arr = [];
            foreach ($data as $key => $value) {
                $arr[$key]["student"] = $value->first_name . " " . $value->last_name;
                $arr[$key]["student_id"] = $value->id;
                $stud[$key]["student_id"] = $value->id;
                $data_merit = Performance::where([
                    ["student_id", "=", $value->id],
                    ["type", "=", "merit"]
                ])->sum('points');
                $data_demerit = Performance::where([
                    ["student_id", "=", $value->id],
                    ["type", "=", "demerit"]
                ])->sum('points');
                $cal = $data_merit - $data_demerit;
                $cal = max($cal, 0);
                $arr[$key]["total_points"] = 100 - $data_demerit;
                $cal = $cal / 15;
                $average = $cal * 100;
                $merit = 100 - $data_demerit;
                $percentage = $merit * 0.3;
                $arr[$key]["average"] = $average;
                $arr[$key]["percentage"] = $percentage;
                $arr[$key]["merits"] = 100 - $data_demerit;
                $arr[$key]["demerits"] = $data_demerit;
            }

            return DataTables::of($arr)->addIndexColumn()->make(true);

        }
    }

}
