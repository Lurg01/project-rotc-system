@extends('layouts.admin.app')
<meta name="csrf-token" content="{{ csrf_token() }}" />
@section('title', 'Admin | Manage Student')

@section('content')
    <div class="modal fade" id="a_semester" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="a_semester_title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" id="a_semester_header">
                    <h6 class="modal-title text-white" id="a_semester_title">Create Student</h6>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body py-3">
                    <form class="category_form" autocomplete="off">
                        <label class="fw-bold">Semester</label>
                        <div class="input-group input-group-outline mb-3 ">
                            <select class="form-control" name="semester" id="semester">
                                <option value="1">1st Semester</option>
                                <option value="2">2nd Semester</option>
                            </select>
                        </div>
                        <label class="fw-bold">Year</label>
                        <div class="input-group input-group-outline mb-3 ">
                            <input type="number" class="form-control" name="year" id="year">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn float-end btn_add_category btn-primary"
                        onclick="save()">Submit</button>
                    <button data-dismiss="modal" type="button" class="btn float-end btn_update_category btn-primary"
                        onclick="">Close</button>
                </div>
            </div>
        </div>
    </div>
    {{-- CONTAINER --}}
    <div class="container-fluid py-4">
        @include('layouts.includes.alert')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form>
                    <div class="form-group">
                        <select id="filter_platoon" class="form-control form-control-sm"
                            onchange="filterStudentByPlatoon(this)">
                            <option value="0">--- All Platoon---
                            </option>
                            @foreach ($platoons as $id => $platoon)
                                <option value="{{ $id }}">{{ $platoon }}</option>
                            @endforeach
                        </select>
                        <br />
                        <select id="filter_sem" class="form-control form-control-sm mb-4"
                            onchange="filterStudentBySemester(this)">
                            <option value="0">--- All Semester ---
                            </option>
                            @foreach ($semesters as $id => $semester)
                                @if ($semester == 1)
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
                                <option value="{{ $year }}">{{ $year }} - {{ $year + 1 }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <div class="card">
                    <div class="card-body">
                        {{-- @if ($message) --}}
                        {{-- <div class="alert alert-warning" role="alert">
                                {{ __('Sorry, the email you have entered ') }}
                            </div> --}}
                        {{-- @endif --}}
                        <button class="float-right btn btn-sm btn-primary me-3" data-toggle="modal"
                            data-target="#a_semester">Create
                            Student +</button>
                        <!-- <a class="float-right btn btn-sm btn-primary me-3"
                                    href="{{ route('admin.students.create') }}">Create
                                    Student +</a> -->
                        <br><br>
                        <div class="table-responsive">
                            <table class="table table-flush table-hover student_dt">
                                <caption>List of Student</caption>
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Student ID</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Last Name</th>
                                        <th>Sex</th>
                                        <th>Course</th>
                                        <th>Platoon</th>
                                        <!-- <th>Registered At</th> -->
                                        <th>Semester</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Display students --}}
                                </tbody>
                            </table>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- End CONTAINER --}}

@endsection
@section('script')
    <script>
        function save() {
            var sem = $("#semester").val();
            var year = $("#year").val();
            var type = "POST";
            var ajaxurl = '/semesteryear';
            var form = new FormData();
            form.append("student_id", 0);
            form.append("semester", sem);
            form.append("year", year);
            $.ajax({
                type: type,
                url: ajaxurl,
                headers: {
                    "Accept": "application/json",
                },
                processData: false,
                mimeType: "multipart/form-data",
                contentType: false,
                data: form,
                success: function(data) {
                    console.log(data);
                    window.location.href = "/admin/students/create";
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
        $(document).ready(function() {
            var a = new Date().getFullYear();
            $("#year").val(a);
        });
    </script>
@endsection
