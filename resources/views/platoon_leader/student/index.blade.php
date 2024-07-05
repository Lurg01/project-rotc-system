@extends('layouts.platoon_leader.app')

@section('title', 'Platoon Leader | Manage Student')

@section('content')

    {{-- CONTAINER --}}
    <div class="container-fluid py-4">
        @include('layouts.includes.alert')
        <div class="row justify-content-center">
            <div class="col-md-12">
                <form>
                    <div class="form-group">
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
                        <br>
                        <select class="form-control form-control-sm" onchange="filterStudentByCourse(this)">
                            <option value="0">--- All Courses---
                            </option>
                            @foreach ($courses as $id => $course)
                                <option value="{{ $id }}">{{ $course }}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-flush table-hover student_dt">
                                <caption>List of Student by Platoon - {{ auth()->user()->student->platoon->name }}</caption>
                                <thead class="thead-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Student ID</th>
                                        <th>First Name</th>
                                        <th>Middle Name</th>
                                        <th>Last Name</th>
                                        <th>Sex</th>
                                        <th>Course</th>
                                        <th>Registered At</th>
                                        <th></th>
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
