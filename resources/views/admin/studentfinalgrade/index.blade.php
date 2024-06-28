@extends('layouts.admin.app')

@section('title', 'Admin | Students Grades')

@section('content')

{{-- CONTAINER --}}
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <form>
                <div class="form-group">
                    <select id="filter_platoon" class="form-control form-control-sm" onchange="filterStudentByPlatoon(this)">
                        <option value="0">--- All Platoon---
                        </option>
                        @foreach ($platoons as $id => $platoon)
                        <option value="{{ $id }}">{{ $platoon }}</option>
                        @endforeach
                    </select>
                    <br />
                    <select id="filter_sem" class="form-control form-control-sm mb-4" onchange="filterStudentBySemester(this)">
                        <option value="0">--- All Semester ---
                        </option>
                        @foreach ($semesters as $id => $semester)
                        @if($semester == 1)
                        <option value="{{ $semester }}">{{ $semester }}st Semester</option>
                        @else
                        <option value="{{ $semester }}">{{ $semester }}nd Semester</option>
                        @endif
                        @endforeach
                    </select>
                    <select id="filter_year" class="form-control form-control-sm" onchange="filterStudentByYear(this)">
                        <option value="0">--- All Years---
                        </option>
                        @foreach ($years as $id => $year)
                        <option value="{{ $year }}">{{ $year }} - {{ $year+1 }}</option>
                        @endforeach
                    </select>
                </div>
            </form>
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-flush table-hover final_grade_dt">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Student ID</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Last Name</th>
                                    <th>Grade</th>
                                    <th>Equivalent</th>
                                    <th>Remarks</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .dataTables_info {
        display: none !important;
    }
</style>
{{-- End CONTAINER --}}

@endsection
{{-- @section('script')
<script>
    let stid = 0;
    let acad = 0;
    let attendance = 0;
    let aptitude = 0;

    const list_columns = [{
            data: "id",
            render(data) {
                return data;
            },
        },
        {
            data: "student_id",
            render(data) {
                stid = data;
                return data;
            },
        },
        {
            data: "first_name",
            render(data) {
                return data;
            },
        },
        {
            data: "middle_name",
            render(data) {
                return data;
            },
        },
        {
            data: "last_name",
            render(data) {
                return data;
            },
        },
        {
            data: "acadgrade.grade",
            render(data) {
                if (data) {
                    return "<p id='grade-" + stid + "'>" + data + "</p>";
                } else {
                    return "<p id='grade-" + stid + "'>" + 0 + "</p>";
                }
            },
        },
        {
            data: "acadgrade.grade",
            render(data) {
                let a = 5.0;
                if (data >= 98) {
                    a = 1.0;
                } else if (data >= 95 && data <= 97) {
                    a = 1.25;
                } else if (data >= 92 && data <= 94) {
                    a = 1.5;
                } else if (data >= 89 && data <= 91) {
                    a = 1.75;
                } else if (data >= 86 && data <= 88) {
                    a = 2.0;
                } else if (data >= 83 && data <= 85) {
                    a = 2.25;
                } else if (data >= 80 && data <= 82) {
                    a = 2.5;
                } else if (data >= 77 && data <= 79) {
                    a = 2.75;
                } else if (data >= 75 && data <= 76) {
                    a = 3;
                } else if (data <= 74) {
                    a = 5;
                }
                return "<p id='eq-" + stid + "'>" + a + "</p>";
            },
        },
        {
            data: "Remarks",
            render(data) {
                let a = "";
                if (data == "0") {
                    a += '<label>PASSED</label>';
                } else if (data == "1") {
                    a += '<label>FAILED</label>';
                } else if (data == "3") {
                    a += '<label>DROPPED</label>';
                } else {
                    a += '<label>INCOMPLETE</label>';
                }
                return a;
            },
        },
    ];
    c_index(
        $(".final_grade_dt"),
        `{{URL::to(
        'admin/finalstudentgrade/get')}}`,
        list_columns,
        1,
        true
    );
</script>
@endsection --}}