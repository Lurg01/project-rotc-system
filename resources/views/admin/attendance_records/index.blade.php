@extends('layouts.admin.app')

@section('title', 'Admin | Attendance Records V2')

@section('content')
    <style>
        .hide {
            display: none;
        }
    </style>
    {{-- CONTAINER --}}
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div id="atn_record_alert" class="alert alert-success hide" role="alert">
                    {{ __('Successfully Added to Attendance Record') }}
                </div>
                <!-- <div>
                        <div class="card">
                            <div class="card-header">
                                Add Attendance Record
                            </div>
                            <div class="card-body">
                                <div class="form">
                                    <div class="row">
                                        <div class="col">
                                            <select class="form-control" name="course" id="course" onchange="filterAttendanceRecords()">
                                                <option value="">All Course</option>
                                                <?php foreach ($course as $data => $value) {  ?>
                                                    <option value=<?php echo $value->id; ?>><?php echo $value->name; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table id="student_dt" class="table table-hover student_dt">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Student ID</th>
                                                <th>First Name</th>
                                                <th>Middle Name</th>
                                                <th>Last Name</th>
                                                <th>Course</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <button onclick=submit_record() class="float-right btn btn-sm btn-primary me-3" >
                                    Add Record +
                            </button>
                            </div>
                        </div>
                    </div> -->
                <br>
                <div>

                </div>
                <div class="card">
                    <div class="card-header">
                        List Attendance Record
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover attendance_dt">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Student</th>
                                        <th>1st</th>
                                        <th>2nd</th>
                                        <th>3rd</th>
                                        <th>4th</th>
                                        <th>5th</th>
                                        <th>6th</th>
                                        <th>7th</th>
                                        <th>8th</th>
                                        <th>9th</th>
                                        <th>10th</th>
                                        <th>11th</th>
                                        <th>12th</th>
                                        <th>13th</th>
                                        <th>14th</th>
                                        <th>15th</th>
                                        <th>Total Points</th>
                                        <th>Average</th>
                                        <th>Percentage (30%)</th>
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
        let obj = [{
            student_id: ""
        }];

        const list_columns = [{
                data: "student_id",
                render(data) {
                    return data;
                },
            },
            {
                data: "student",
                render(data) {
                    return data;
                },
            },
            {
                data: "full_day",
                render(data) {
                    let cleardata = data.split(" ").join("");
                    const ar = cleardata.split("-");
                    if (ar[1] == 0 || ar[1] == "") {
                        // return "<input id='"+ar[0]+"-day_one'  type='checkbox' value=''>";
                        return "0";
                    } else {
                        return "1";
                    }
                },
            },
            {
                data: "full_day",
                render(data) {
                    let cleardata = data.split(" ").join("");
                    const ar = cleardata.split("-");
                    if (ar[2] == 0 || ar[2] == "") {
                        // return "<input id='"+ar[0]+"-day_two' type='checkbox' value=''>";
                        return "0";
                    } else {
                        return "1";
                    }
                },
            },
            {
                data: "full_day",
                render(data) {
                    let cleardata = data.split(" ").join("");
                    const ar = cleardata.split("-");
                    if (ar[3] == 0 || ar[3] == "") {
                        // return "<input id='"+ar[0]+"-day_three' type='checkbox' value=''>";
                        return "0";
                    } else {
                        return "1";
                    }
                },
            },
            {
                data: "full_day",
                render(data) {
                    let cleardata = data.split(" ").join("");
                    const ar = cleardata.split("-");
                    if (ar[4] == 0 || ar[4] == "") {
                        // return "<input id='"+ar[0]+"-day_four' type='checkbox' value=''>";
                        return "0";
                    } else {
                        return "1";
                    }
                },
            },
            {
                data: "full_day",
                render(data) {
                    let cleardata = data.split(" ").join("");
                    const ar = cleardata.split("-");
                    if (ar[5] == 0 || ar[5] == "") {
                        // return "<input id='"+ar[0]+"-day_five' type='checkbox' value=''>";
                        return "0";
                    } else {
                        return "1";
                    }
                },
            },
            {
                data: "full_day",
                render(data) {
                    let cleardata = data.split(" ").join("");
                    const ar = cleardata.split("-");
                    if (ar[6] == 0 || ar[6] == "") {
                        // return "<input id='"+ar[0]+"-day_six' type='checkbox' value=''>";
                        return "0";
                    } else {
                        return "1";
                    }
                },
            },
            {
                data: "full_day",
                render(data) {
                    let cleardata = data.split(" ").join("");
                    const ar = cleardata.split("-");
                    if (ar[7] == 0 || ar[7] == "") {
                        // return "<input id='"+ar[0]+"-day_seven' type='checkbox' value=''>";
                        return "0";
                    } else {
                        return "1";
                    }
                },
            },
            {
                data: "full_day",
                render(data) {
                    let cleardata = data.split(" ").join("");
                    const ar = cleardata.split("-");
                    if (ar[8] == 0 || ar[8] == "") {
                        // return "<input id='"+ar[0]+"-day_eight' type='checkbox' value=''>";
                        return "0";
                    } else {
                        return "1";
                    }
                },
            },
            {
                data: "full_day",
                render(data) {
                    let cleardata = data.split(" ").join("");
                    const ar = cleardata.split("-");
                    if (ar[9] == 0 || ar[9] == "") {
                        // return "<input id='"+ar[0]+"-day_nine' type='checkbox' value=''>";
                        return "0";
                    } else {
                        return "1";
                    }
                },
            },
            {
                data: "full_day",
                render(data) {
                    let cleardata = data.split(" ").join("");
                    const ar = cleardata.split("-");
                    if (ar[10] == 0 || ar[10] == "") {
                        // return "<input id='"+ar[0]+"-day_ten' type='checkbox' value=''>";
                        return "0";
                    } else {
                        return "1";
                    }
                },
            },
            {
                data: "full_day",
                render(data) {
                    let cleardata = data.split(" ").join("");
                    const ar = cleardata.split("-");
                    if (ar[11] == 0 || ar[11] == "") {
                        // return "<input id='"+ar[0]+"-day_eleven' type='checkbox' value=''>";
                        return "0";
                    } else {
                        return "1";
                    }
                },
            },
            {
                data: "full_day",
                render(data) {
                    let cleardata = data.split(" ").join("");
                    const ar = cleardata.split("-");
                    if (ar[12] == 0 || ar[12] == "") {
                        // return "<input id='"+ar[0]+"-day_twelve' type='checkbox' value=''>";
                        return "0";
                    } else {
                        return "1";
                    }
                },
            },
            {
                data: "full_day",
                render(data) {
                    let cleardata = data.split(" ").join("");
                    const ar = cleardata.split("-");
                    if (ar[13] == 0 || ar[13] == "") {
                        // return "<input id='"+ar[0]+"-day_thirtheen' type='checkbox' value=''>";
                        return "0";
                    } else {
                        return "1";
                    }
                },
            },
            {
                data: "full_day",
                render(data) {
                    let cleardata = data.split(" ").join("");
                    const ar = cleardata.split("-");
                    if (ar[14] == 0 || ar[14] == "") {
                        // return "<input id='"+ar[0]+"-day_fourtheen' type='checkbox' value=''>";
                        return "0";
                    } else {
                        // return "<input id='"+ar[0]+"-day_fourtheen' type='checkbox' value='' checked>";
                        return "1";
                    }
                },
            },
            {
                data: "full_day",
                render(data) {
                    let cleardata = data.split(" ").join("");
                    const ar = cleardata.split("-");
                    if (ar[15] == 0 || ar[15] == "") {
                        // return "<input id='"+ar[0]+"-day_fiftheen' type='checkbox' value=''>";
                        return "0";
                    } else {
                        return "1";
                    }
                },
            },
            {
                data: "full_day",
                render(data) {
                    let cleardata = data.split(" ").join("");
                    const ar = cleardata.split("-");
                    for (let i = 0; i < ar.length; i++) {                  
                        if (ar[i] == 0 || ar[i] == "") {
                            return "0";
                        } else {
                            switch (ar[i]) {
                                case ar[15]:    return ar.length - 2;   break;
                                case ar[14]:    return ar.length - 3;   break;
                                case ar[13]:    return ar.length - 4;   break;
                                case ar[12]:    return ar.length - 5;   break;
                                case ar[11]:    return ar.length - 6;   break;
                                case ar[10]:    return ar.length - 7;   break;
                                case ar[9]:     return ar.length - 8;   break;
                                case ar[8]:     return ar.length - 9;   break;
                                case ar[7]:     return ar.length - 10;  break;
                                case ar[6]:     return ar.length - 11;  break;
                                case ar[5]:     return ar.length - 12;  break;
                                case ar[4]:     return ar.length - 13;  break;
                                case ar[3]:     return ar.length - 14;  break;
                                case ar[2]:     return ar.length - 15;  break;
                                case ar[1]:     return ar.length - 16;  break;
                                default:    break;

                            }
                        }
                    }

                },
            },
            {
                data: "full_day",
                render(data) {
                    let cleardata = data.split(" ").join("");
                    const ar = cleardata.split("-");
                    for (let i = 0; i < ar.length; i++) {                  
                        if (ar[i] == 0 || ar[i] == "") {
                            return "0";
                        } else {
                            switch (ar[i]) {
                                case ar[15]:     return ar.length - 2 + ".0" ;  break;
                                case ar[14]:    return ar.length - 3 + ".0" ;   break;
                                case ar[13]:    return ar.length - 4 + ".0" ;   break;  
                                case ar[12]:    return ar.length - 5 + ".0" ;   break;
                                case ar[11]:    return ar.length - 6 + ".0" ;   break;
                                case ar[10]:    return ar.length - 7 + ".0" ;   break;
                                case ar[9]:     return ar.length - 8 + ".0" ;   break;
                                case ar[8]:     return ar.length - 9 + ".0" ;   break;
                                case ar[7]:     return ar.length - 10 + ".0" ;  break;
                                case ar[6]:     return ar.length - 11 + ".0" ;  break;
                                case ar[5]:     return ar.length - 12 + ".0" ;  break;
                                case ar[4]:     return ar.length - 13 + ".0" ;  break;
                                case ar[3]:     return ar.length - 14 + ".0" ;  break;
                                case ar[2]:     return ar.length - 15 + ".0" ;  break;
                                case ar[1]:     return ar.length - 16 + ".0" ;  break;
                                default:    break;

                            }
                        }
                    }
                },
            },
            {
                data: "full_day",
                render(data) {
                    let cleardata = data.split(" ").join("");
                    const ar = cleardata.split("-");
               
                    for (let i = 0; i < ar.length; i++) {                  
                        if (ar[i] == 0 || ar[i] == "") {
                            return "0";
                        } else {
                            switch (ar[i]) {
                                case ar[15]:  return calculatePercentage(15, 50) + "%";  break;
                                case ar[14]:  return calculatePercentage(14, 50) + "%";  break;
                                case ar[13]:  return calculatePercentage(13, 50)  + "%"; break;
                                case ar[12]:  return calculatePercentage(12, 50)  + "%"; break;
                                case ar[11]:  return calculatePercentage(11, 50)  + "%"; break;
                                case ar[10]:  return calculatePercentage(10, 50)  + "%"; break;
                                case ar[9]:   return calculatePercentage(9, 50)  + "%";  break;
                                case ar[8]:   return calculatePercentage(8, 50)  + "%";  break;
                                case ar[7]:   return calculatePercentage(7, 50)  + "%";  break;
                                case ar[6]:   return calculatePercentage(6, 50)  + "%";  break;
                                case ar[5]:   return calculatePercentage(5, 50)  + "%";  break;
                                case ar[4]:   return calculatePercentage(4, 50)  + "%";  break;
                                case ar[3]:   return calculatePercentage(3, 50)  + "%";  break;
                                case ar[2]:   return calculatePercentage(2, 50)  + "%";  break;
                                case ar[1]:   return calculatePercentage(1, 50)  + "%";  break;
                                default:  break;

                            }
                        }
                    }
                    
                    
                    // }
                },
            },
        ];
        function calculatePercentage(part, total) {
            // Calculate the percentage
            const percentage = (part / total) * 100;
            return percentage;
        }


        var table = $('.student_dt').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('platoon_leader.records') }}",
            columns: [{
                    data: "student_id",
                    render(data) {
                        return "<input type='checkbox' onchange=add_record(this," + data + ")>";
                    },
                },
                {
                    data: "student_id",
                    render(data) {
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
                    data: "name",
                    render(data) {
                        return data;
                    },
                },
            ]
        });

        c_index(
            $(".attendance_dt"),
            "{{ route('admin.records') }}",
            list_columns,
            1,
            true
        );

        function filterAttendanceRecords() {
            const record_columns = [{
                    data: "id",
                    render(data) {
                        return "<input type='checkbox'>";
                    },
                },
                {
                    data: "student_id",
                    render(data) {
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
                    data: "name",
                    render(data) {
                        return data;
                    },
                },
            ];
            // c_index(
            //     $(".student_dt"),
            //     route("admin.attendance-records.records", {
            //         course:$('#course').val(),
            //     }),
            //     record_columns,
            //     1,
            //     true
            // );
        }

        function add_record(checkbox, stud_id) {
            if (checkbox.checked == true) {
                if (obj.hasOwnProperty(stud_id)) {} else {
                    obj.push({
                        student_id: stud_id
                    });
                }
            } else {
                obj.pop({
                    student_id: stud_id
                });
            }
            // console.log(obj);
        }

        function submit_record() {
            // var formData = {
            //     data: obj
            // };
            var type = "GET";
            var ajaxurl = '/admin/attendance-records/create';

            $.ajax({
                type: type,
                url: ajaxurl,
                // data: formData,
                success: function(data) {
                    if (data == "true") {
                        c_index(
                            $(".attendance_dt"),
                            route("admin.records"),
                            list_columns,
                            1,
                            true
                        );
                    } else {
                        console.log(data);
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });


        }

        submit_record();

        function update_records(data) {
            console.log(data);
        }
    </script>

@endsection
