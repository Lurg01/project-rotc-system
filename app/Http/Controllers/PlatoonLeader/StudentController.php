<?php

namespace App\Http\Controllers\PlatoonLeader;
use App\Models\Otp;
use Carbon\Carbon;
use App\Models\Role;
use App\Models\Course;
use App\Models\Student;
use App\Models\Attendance;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Resources\Student\StudentResource;
use App\Http\Resources\Attendance\AttendanceResource;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\semesteryear;

class StudentController extends Controller
{

    /**
     * Update the user with the given ID in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param mixed $students
     * @return \Illuminate\Http\Response
     */

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
            // if ($request->platoon) {
        
            //     $students = StudentResource::collection(
            //         Student::query()
            //             ->when($request->filled('platoon'), fn ($query) => $query->where('platoon_id', $request->platoon))       
            //             ->with('course', 'platoon', 'user.avatar', 'semesteryears')
            //             ->get());
                
            //     if ($request->platoon && $request->semester) { 
            //         $students = $this->platoonAndSemester($request);
            //     }
            //     if ($request->platoon && $request->year) {
            //         $students = $this->platoonAndyear($request);
            //         }
            //     if ($request->platoon && $request->semester && $request->year) { 
            //         $students = $this->filterByAll($request);
            //     }

            // }
        
            // else 

            if ($request->semester) {
                $students = $this->filterBy($request);
                if ($request->semester && $request->platoon ) { 
                    $students = $this->platoonAndSemester($request);
                }
                if ($request->semester && $request->year) { 
                    $students = $this->semesterAndyear($request);
                }
                if ($request->platoon && $request->semester && $request->year) { 
                    $students = $this->filterByAll($request);
                }
            }
            elseif ($request->year) {
         
                    $students = $this->filterBy($request);
                
                if ($request->year && $request->semester) { 
                    $students = $this->semesterAndyear($request);
                }
                if ($request->year && $request->platoon) { 
                    $students = $this->platoonAndyear($request);
                }
                if ($request->platoon && $request->semester && $request->year) { 
                    $students = $this->filterByAll($request);
                }
            } 
            elseif ($request->course) {
                
                $students = StudentResource::collection(Student::query()
                    ->when($request->course, fn($query) => $query->where('course_id', $request->course))
                    ->with('course', 'platoon', 'user.avatar')
                    ->whereBelongsTo(auth()->user()->student->platoon)
                    ->whereRelation('user', 'role_id', Role::STUDENT)
                    ->get());    

            }
            else {
                $students = StudentResource::collection(Student::query()
                    ->with('course', 'platoon', 'user.avatar', 'semesteryears')
                    ->whereBelongsTo(auth()->user()->student->platoon)
                    ->whereRelation('user', 'role_id', Role::STUDENT)
                    ->get());    
            }
    
        
            return DataTables::of($students) // get all teacher from the current active academic year
                   ->addIndexColumn()
                   ->addColumn('actions', function($row) {
                    $new_row = collect($row);
                    $route_show = route('platoon_leader.students.show', $new_row['id']);
                    $btn = "
                        <div class='dropdown'>
                            <a class='btn btn-sm btn-icon-only text-light' href='#' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            <i class='fas fa-ellipsis-v'></i>
                            </a>
                            <div class='dropdown-menu dropdown-menu-right dropdown-menu-arrow'>
                                <a class='dropdown-item' href='$route_show'>View</a>
                            </div>
                        </div> ";
    
                    return $btn;
    
                   })
                   ->rawColumns(['actions'])
                   ->make(true);
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
        return view('platoon_leader.student.index', [
            'courses' => Course::pluck('name', 'id'),
            'years' => $arr,
            'semesters' => $arr_sem,
        ]);
    }


    // private function filterByAll($request) {
    //     $students = StudentResource::collection(
    //         Student::query()
    //             ->when($request->filled('platoon'), fn ($query) => $query->where('platoon_id', $request->platoon))  
    //             ->with('course', 'platoon', 'user.avatar', 'semesteryears')
    //             ->whereHas('semesteryears', function ($query) use ($request) {
    //                 $query->where([
    //                     ['semester', '=', $request->semester],
    //                     ['year', '=', $request->year],
    //                 ]);
    //             })
    //             ->get());
        
    //     return $students;
    // }

    // private function platoonAndSemester($request) {
    //     $students = StudentResource::collection(
    //         Student::query()
    //             ->when($request->filled('platoon'), fn ($query) => $query->where('platoon_id', $request->platoon))  
    //             ->with('course', 'platoon', 'user.avatar', 'semesteryears')
    //             ->whereHas('semesteryears', function ($query) use ($request) {
    //                 $query->where([
    //                     ['semester', '=', $request->semester],
    //                 ]);
    //         })->get());
    //     return $students;
    // }

    // private function platoonAndyear($request) {
    //     $students = StudentResource::collection(
    //         Student::query()
    //             ->when($request->filled('platoon'), fn ($query) => $query->where('platoon_id', $request->platoon))  
    //             ->with('course', 'platoon', 'user.avatar', 'semesteryears')
    //             ->whereHas('semesteryears', function ($query) use ($request) {
    //                 $query->where([
    //                     ['year', '=', $request->year],
    //                 ]);
    //             })->get());
    //     return $students;
    // }

    private function semesterAndyear($request) {
        $students = StudentResource::collection(
            Student::query()->when($request->filled('platoon'))->with('course', 'platoon', 'user.avatar', 'semesteryears')
                ->whereHas('semesteryears', function ($query) use ($request) {
                    $query->where([
                        ['semester','=', $request->semester],
                        ['year', '=', $request->year],
                    ]);
                })              
                ->whereBelongsTo(auth()->user()->student->platoon)
                ->whereRelation('user', 'role_id', Role::STUDENT)->get());
        return $students;
    }

    private function filterBy($request) {
        $requestFilter = null;
        $selected = '';
        if ($request->semester) {
            $requestFilter = $request->semester;
            $selected = 'semester';
        }elseif ($request->year) {
            $requestFilter = $request->year;
            $selected = 'year';
        }
 
        $students = StudentResource::collection(
            Student::query()->when($request->filled('platoon'))->with('course', 'platoon', 'user.avatar', 'semesteryears')
                ->whereHas('semesteryears', function ($query) use ($requestFilter, $selected) {
                    $query->where([
                        [$selected, '=', $requestFilter],
                    ]); })
                ->whereBelongsTo(auth()->user()->student->platoon)
                ->whereRelation('user', 'role_id', Role::STUDENT)
                ->get());    

        return $students;
    } 

    public function show(Request $request, Student $student)
    {
        if(request()->ajax())
        {
            $attendances = AttendanceResource::collection(
                Attendance::query()
                ->when($request->query('date_time_in') && $request->query('date_time_out'), 
                    fn($query) => $query->whereBetween('created_at', [Carbon::parse($request->date_time_in)->startOfDay(), Carbon::parse($request->date_time_out)->endOfDay()]))
                ->when($request->query('date_time_in') && !$request->query('date_time_out'), 
                    fn($query) => $query->whereDate('created_at', $request->date_time_in ))
                ->when($request->query('date_time_out') && !$request->query('date_time_in'), 
                    fn($query) => $query->whereDate('date_time_out', $request->date_time_out ))
                ->with('student')
                ->whereBelongsTo($student)
                ->latest()
                ->get()
            );

            return DataTables::of($attendances)->addIndexColumn()->make(true);
        }
   
        $string = $student->student_id; 
        $qrcode = QrCode::eyeColor(0, 45, 206, 137, 0, 0, 0)->size(280)->generate($string);
        return view('platoon_leader.student.show', [
            'student' => $student->load('user.avatar', 'course', 'platoon', 'performances'), 'qrcode' => $qrcode
        ]);
    }
}