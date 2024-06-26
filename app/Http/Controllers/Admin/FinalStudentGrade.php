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
    public function index()
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

    public function show()
    {
        $data = Student::with("acadgrade")->get();
        return  DataTables::of($data)->addIndexColumn()->make(true);
    }
}
