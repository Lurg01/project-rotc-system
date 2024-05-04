@extends('layouts.student.app')

@section('title', 'Student Grade')

@section('content')

{{-- CONTAINER --}}
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-flush table-hover student_dt">
                            <thead class="thead-light">
                                <tr>
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
{{-- End CONTAINER --}}

@endsection
@section('script')
<script>
    let stid = 0;

    const list_columns = [{
            data: "grade",
            render(data) {
                if (data) {
                    return "<p id='grade-" + stid + "'>" + data + "</p>";
                } else {
                    return "<p id='grade-" + stid + "'>" + 0 + "</p>";
                }
            },
        },
        {
            data: "grade",
            render(data) {
                if (data) {
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
                } else {
                    return "<p id='eq-" + stid + "'>" + 0 + "</p>";
                }
            },
        },
        {
            data: "remarks",
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

    var table = $('.student_dt').DataTable({
        processing: true,
        serverSide: true,
        ajax: `{{URL::to("student/mestudentgrade/show")}}`,
        columns: list_columns
    });
</script>
@endsection