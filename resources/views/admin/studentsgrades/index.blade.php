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
                        <table class="table table-flush table-hover grade_dt">
                            <thead class="thead-light">
                                <tr>
                                    <th>#</th>
                                    <th>Student ID</th>
                                    <th>First Name</th>
                                    <th>Middle Name</th>
                                    <th>Last Name</th>
                                    <th>Attendance</th>
                                    <th>Aptitude</th>
                                    <th>ACAD</th>
                                    <th>Total</th>
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
                data: "attendance",
                render(data) {
                    attendance = data;
                    return "<p id='attendance-" + stid + "'>" + data + "</p>";
                },
            },
            {
                data: "aptitude",
                render(data) {
                    aptitude = data;
                    return "<p id='aptitude-" + stid + "'>" + data + "</p>";
                },
            },
            {
                data: "acadgrade.acad",
                render(data) {
                    acad = data;
                    return data;
                },
            },
            {
                data: "grade",
                render(data) {
                    let a = parseInt(attendance) + parseInt(aptitude) + parseInt(acad);
                    if (a !== a) {
                        a = 0;
                    }
                    return a;
                },
            },
        ];
        c_index(
            $(".grade_dt"),
            `{{URL::to("admin/studentgrade/show")}}`,
            list_columns,
            1,
            true
        );
    </script>
@endsection --}}