<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\Student;
use App\Models\Platoon;
use Yajra\DataTables\Facades\DataTables;

use App\Models\AttendanceRecords;
use App\Models\semesteryear;
use App\Models\AttendanceRecordsModel; 
use App\Http\Resources\AttendanceRecords\AttendanceRecordsResource;

class FinalStudentGrade extends Controller
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
            if (session()->get('is_otp') == null) {
                return redirect('/otp');
            }
        }

        if (request()->ajax()) {
            $data = Student::with("acadgrade")->get();
            $arr = [];
            if ($request->platoon) {
                foreach ($data as $key => $value) {
                    if ($value->platoon_id == $request->platoon) { 
                        $key =  $value->id;
                        $arr[$key]['id'] = $value->id;
                        $arr[$key]['student_id'] = $value->student_id;
                        $arr[$key]['first_name'] = $value->first_name;
                        $arr[$key]['middle_name'] = $value->middle_name;
                        $arr[$key]['last_name'] = $value->last_name;
                        $arr[$key]['acadgrade.grade'] = $value->acadgrade->grade;
                    }
                }
            } elseif ($request->semester) {
                $arr = $this->getByAny($request, $data);
            } elseif ($request->year) {
                $arr = $this->getByAny($request, $data);
            } else {
                $arr = $this->get();
            }
       
            return  DataTables::of($arr)->addIndexColumn()->make(true);
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

        return view('admin.studentfinalgrade.index' , [
            'platoons' => Platoon::pluck('name', 'id'),
            'years' => $arr,
            'semesters' => $arr_sem,
        ]);
    }
    
    private function get()
    {
        $data_all = Student::with("acadgrade")->get();
        foreach ($data_all as $key => $value) {
            $arr[$key]['id'] = $value->id;
            $arr[$key]['student_id'] = $value->student_id;
            $arr[$key]['first_name'] = $value->first_name;
            $arr[$key]['middle_name'] = $value->middle_name;
            $arr[$key]['last_name'] = $value->last_name;
            $arr[$key]['acadgrade.grade'] = $value->acadgrade->grade;
        }
        return $arr;
    }
    
    private function getByAny($request, $data) {

        if ($request->semester) {
            foreach ($data as $key => $value) {
                if ($value->semesteryears->semester == $request->semester) { 
                    $key=  $value->id;
                    $arr[$key]['id'] = $value->id;
                    $arr[$key]['student_id'] = $value->student_id;
                    $arr[$key]['first_name'] = $value->first_name;
                    $arr[$key]['middle_name'] = $value->middle_name;
                    $arr[$key]['last_name'] = $value->last_name;
                    $arr[$key]['acadgrade.grade'] = $value->acadgrade->grade;
                }
            }
        }
        if ($request->year) {
            foreach ($data as $key => $value) {
                if ($value->semesteryears->year == $request->year) { 
                    $key =  $value->id;
                    $arr[$key]['id'] = $value->id;
                    $arr[$key]['student_id'] = $value->student_id;
                    $arr[$key]['first_name'] = $value->first_name;
                    $arr[$key]['middle_name'] = $value->middle_name;
                    $arr[$key]['last_name'] = $value->last_name;
                    $arr[$key]['acadgrade.grade'] = $value->acadgrade->grade;
                }
            }
        }
  
        return $arr;
    }


    public function show()
    {
        $data = Student::with("acadgrade")->get();

        return  DataTables::of($data)->addIndexColumn()->make(true);
    }
}
