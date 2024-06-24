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
use App\Models\semesteryear;

class StudentController extends Controller
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

            $students = StudentResource::collection(
                Student::query()
                    ->when($request->filled('platoon'), fn ($query) => $query->where('platoon_id', $request->platoon))
                    ->with('course', 'platoon', 'user.avatar', 'semesteryears')
                    ->whereHas('semesteryears', function ($query) {
                        $query->where([
                            ['semester', '=', "1"],
                        ]);
                    })
                    ->get()
            );

            if ($request->platoon == "0") {
                $students = StudentResource::collection(Student::with('course', 'platoon', 'user.avatar', 'semesteryears')
                    ->whereHas('semesteryears', function ($query) {
                        $query->where('semester', '=', "1");
                    })->get());
            }
            $sem = "";
            $year = "";
            if ($request->year) {
                $year = $request->year;
            }
            if ($request->semester == "2") {
                $sem = "2";
            } else if ($request->semester == "1") {
                $sem = "1";
            }

            if ($request->platoon == "0") {
                if ($sem != "") {
                    $students = StudentResource::collection(
                        Student::with('course', 'platoon', 'user.avatar', 'semesteryears')
                            ->whereHas('semesteryears', function ($query) use ($sem) {
                                $query->where([
                                    ['semester', '=', $sem],
                                ]);
                            })
                            ->get()
                    );
                } else if ($year != "") {
                    $students = StudentResource::collection(
                        Student::with('course', 'platoon', 'user.avatar', 'semesteryears')
                            ->whereHas('semesteryears', function ($query) use ($year) {
                                $query->where([
                                    ['year', '=', $year],
                                ]);
                            })
                            ->get()
                    );
                } else if ($year != "" && $sem != "") {
                    $students = StudentResource::collection(
                        Student::with('course', 'platoon', 'user.avatar', 'semesteryears')
                            ->whereHas('semesteryears', function ($query) use ($year, $sem) {
                                $query->where([
                                    ['semester', '=', $sem],
                                    ['year', '=', $year],
                                ]);
                            })
                            ->get()
                    );
                }
            } else {
                if ($sem != "") {
                    $a = Student::with('course', 'platoon', 'user.avatar', 'semesteryears')
                        ->get();

                    $students = StudentResource::collection(
                        Student::query()
                            ->when($request->filled('platoon'), fn ($query) => $query->where('platoon_id', $request->platoon))
                            ->with('course', 'platoon', 'user.avatar', 'semesteryears')
                            ->whereHas('semesteryears', function ($query) use ($sem) {
                                $query->where([
                                    ['semester', '=', $sem],
                                ]);
                            })
                            ->get()
                    );
                } else if ($year != "") {
                    $students = StudentResource::collection(
                        Student::query()
                            ->when($request->filled('platoon'), fn ($query) => $query->where('platoon_id', $request->platoon))
                            ->with('course', 'platoon', 'user.avatar', 'semesteryears')
                            ->whereHas('semesteryears', function ($query) use ($year) {
                                $query->where([
                                    ['year', '=', $year],
                                ]);
                            })
                            ->get()
                    );
                } else if ($year != "" && $sem != "") {
                    $students = StudentResource::collection(
                        Student::query()
                            ->when($request->filled('platoon'), fn ($query) => $query->where('platoon_id', $request->platoon))
                            ->with('course', 'platoon', 'user.avatar', 'semesteryears')
                            ->whereHas('semesteryears', function ($query) use ($year, $sem) {
                                $query->where([
                                    ['semester', '=', $sem],
                                    ['year', '=', $year],
                                ]);
                            })
                            ->get()
                    );
                }
            }

            return DataTables::of($students) // get all teacher from the current active academic year
                ->addIndexColumn()
                ->addColumn('actions', function ($row) {
                    $new_row = collect($row);
                    $route_show = route('admin.students.show', $new_row['id']);
                    $route_edit = route('admin.students.edit', $new_row['id']);
                    // <a class='dropdown-item' href='$route_show'>View</a>
                    $btn = "
                        <div class='dropdown'>
                            <a class='btn btn-sm btn-icon-only text-light' href='#' role='button' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                            <i class='fas fa-ellipsis-v'></i>
                            </a>
                            <div class='dropdown-menu dropdown-menu-right dropdown-menu-arrow'>

                                <a class='dropdown-item' href='$route_show'>View</a>
                                <a class='dropdown-item' href='$route_edit'>Edit</a>

                                <a class='dropdown-item' href='javascript:void(0)' onclick='c_destroy($new_row[id],`admin.students.destroy`,`.student_dt`)'>Delete</a>
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
        return view('admin.student.index', [
            'platoons' => Platoon::pluck('name', 'id'),
            'years' => $arr,
            'semesters' => $arr_sem,
        ]);
    }

    public function create()
    {
        return view('admin.student.create', [
            'departments' => Department::with('courses')->get(),
            'platoons' => Platoon::pluck('name', 'id'),
        ]);
    }

    public function store(StudentRequest $request, UserService $service)
    {
        $student = Student::create($request->validated());
        $student->status = 1;
        $service->create_account(model: $student, email: $request->email, role: $request->is_platoon_leader ? Role::PLATOON_LEADER : Role::STUDENT);
        $c = Student::all()->count();
        $a = semesteryear::find($c);
        $a->student_id = $c;
        $a->save();

        return to_route('admin.students.index')->with(['success' => 'Student Added Successfully']);
    }

    public function show(Request $request, Student $student)
    {
        if (request()->ajax()) {
            $attendances = AttendanceResource::collection(
                Attendance::query()
                    ->when(
                        $request->query('date_time_in') && $request->query('date_time_out'),
                        fn ($query) => $query->whereBetween('created_at', [Carbon::parse($request->date_time_in)->startOfDay(), Carbon::parse($request->date_time_out)->endOfDay()])
                    )
                    ->when(
                        $request->query('date_time_in') && !$request->query('date_time_out'),
                        fn ($query) => $query->whereDate('created_at', $request->date_time_in)
                    )
                    ->when(
                        $request->query('date_time_out') && !$request->query('date_time_in'),
                        fn ($query) => $query->whereDate('date_time_out', $request->date_time_out)
                    )
                    ->with('student')
                    ->whereBelongsTo($student)
                    ->latest()
                    ->get()
            );

            return DataTables::of($attendances)->addIndexColumn()->make(true);
        }

        return view('admin.student.show', [
            'student' => $student->load('user.avatar', 'course', 'platoon', 'performances')
        ]);
    }

    public function edit(Student $student)
    {
        return view('admin.student.edit', [
            'student' => $student,
            'departments' => Department::with('courses')->get(),
            'platoons' => Platoon::pluck('name', 'id'),
        ]);
    }

    public function update(StudentRequest $request, Student $student)
    {
        $student->update($request->validated());

        $student->user()->updateOrCreate(
            // ['role_id' => Role::STUDENT],
            ['email' => $request->email],
        );

        return to_route('admin.students.index')->with(['success' => 'Student Updated Successfully']);
    }

    public function destroy(Student $student)
    {
        $message = "Working";
        try {
            $student->delete();
            return $this->res(['success' => 'Student Deleted Successfully']);
        } catch (\Exception $e) {
            return $this->res(['success' => 'To remove this Student, you must first delete the record from Acad and Attendance record refer to this student data.']);
        }
    }
}
