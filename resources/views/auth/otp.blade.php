@extends('layouts.main.app')

@section('title', 'ROTC Students Performance Record Management and Monitoring System | Login')
@section('content')
    {{-- <div class="modal fade" id="a_semester" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="a_semester_title" aria-hidden="true"> --}}

    <div class="modal fade" id="myModal" data-backdrop="static" data-keyboard="false" tabindex="-1"
        aria-labelledby="a_semester_title" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header" id="a_semester_header">
                    <h6 class="modal-title text-black" id="a_semester_title">Select Semester and Year</h6>

                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body py-3">
                    <form id="filterForm" action="{{ route('filter.store') }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <div class="input-group input-group-outline mb-3">
                                <select id="filter_sem" name="semester" class="form-control form-control-sm mb-4" required>
                                    <option value="">--- All Semester ---</option>
                                    @foreach ($semesters as $id => $semester)
                                        <option value="{{ $semester }}">
                                            {{ $semester == 1 ? $semester . 'st' : $semester . 'nd' }} Semester</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="input-group input-group-outline mb-3">
                                <select id="filter_year" name="year" class="form-control form-control-sm" required>
                                    <option value="">--- All Years ---</option>
                                    @foreach ($years as $id => $year)
                                        <option value="{{ $year }}">{{ $year }} - {{ $year + 1 }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="mt-3 mb-4">
                            <div class="modal-footer">
                                <button type="submit" class="btn float-end btn_add_category btn-primary"
                                    onclick="save()">Done</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <!-- Page content -->

    <section class="vh-100">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-12">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-6 d-none d-md-block my-auto">
                                <img src="{{ asset('img/auth/student.svg') }}" alt="login" class="img-fluid"
                                    style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-6 d-flex align-items-center">
                                <div class="card-body p-4 p-lg-5 text-black">
                                    <form action="{{ route('api.attemptOtp') }}" method="POST">
                                        @csrf
                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <img class="img-fluid rounded-circle mr-3"
                                                src="{{ asset('img/logo/logo.png') }}" width="75" alt="logo">
                                            <span class="h2 fw-bold mb-0 text-dark">{{ config('app.name') }}</span>
                                        </div>
                                        <h1 id="success"></h1>
                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Verify OTP
                                        </h5>

                                        @include('layouts.includes.alert')

                                        <div class="form-group mb-3">
                                            <div class="input-group input-group-merge input-group-alternative">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                                                </div>
                                                <input class="form-control" type="number" name="otp" maxlength="4"
                                                    oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                                    placeholder="" autocomplete="otp" value="" required>
                                            </div>
                                        </div>
                                        <div class="mt-3 mb-4">
                                            <button class="btn btn-primary btn-lg btn-block" type="submit">Submit</button>
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- End Page content -->
@endsection
@section('script')
    <script type="text/javascript">
        // document.getElementById('filter_sem').addEventListener('change', function() {
        //     if (this.value) {
        //         console.log("Heyyyyyyyyyyyyyyyyyyyyyyyyyy ",   this.value);
        //     }
        // });


        // $(document).ready(function() {
        //     $('#myModal').modal('hide');

        // });


        // $(document).ready(function() {
        //     $('#myModal').modal({
        //         backdrop: 'static',
        //         keyboard: false
        //     });
        // });
    </script>
@endsection
