<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Otp;
use App\Models\Student;
use Yajra\DataTables\Facades\DataTables;

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
        return view('admin.studentfinalgrade.index');
    }

    public function show()
    {
        $data = Student::with("acadgrade")->get();
        return  DataTables::of($data)->addIndexColumn()->make(true);
    }
}
