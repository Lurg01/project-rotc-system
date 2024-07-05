const token = $('meta[name="csrf-token"]').attr("content");
const baseUrl = window.location.origin;
let pond;

$(() => {
    // Activity Logs
    // if (window.location.href === route("platoon_leader.activity_logs.index")) {
    //     const columns = [
    //         {
    //             data: "id",
    //             render(data, type, row) {
    //                 return row.DT_RowIndex;
    //             },
    //         },
    //         { data: "description" },
    //         {
    //             data: "created_at",
    //             render(data) {
    //                 return formatDate(data, "datetime");
    //             },
    //         },
    //         { data: "properties.ip" },
    //     ];
    //     c_index(
    //         $(".activitylog_dt"),
    //         route("platoon_leader.activity_logs.index"),
    //         columns
    //     );
    // }

    /** Start Student Management */

    // Student
    if (window.location.href === route("platoon_leader.students.index")) {
        const student_columns = [
            {
                data: "id",
                render(data, type, row, meta) {
                    return row.DT_RowIndex;
                },
            },
            {
                data: "student_id",
                render(data) {
                    return `<span class='text-capitalize'>${data}</span>`;
                },
            },
            {
                data: "first_name",
                render(data) {
                    return `<span class='text-capitalize'>${data}</span>`;
                },
            },

            {
                data: "middle_name",
                render(data) {
                    return `<span class='text-capitalize'>${data}</span>`;
                },
            },
            {
                data: "last_name",
                render(data) {
                    return `<span class='text-capitalize'>${data}</span>`;
                },
            },
            {
                data: "sex",
                render(data) {
                    return `<span class='text-capitalize'>${data}</span>`;
                },
            },
            {
                data: "course",
                render(data) {
                    return `<span class='text-capitalize'>${data}</span>`;
                },
            },
            {
                data: "created_at",
                render(data) {
                    return formatDate(data, "full");
                },
            },

            { data: "actions", orderable: false, searchable: false },
        ];

        c_index(
            $(".student_dt"),
            route("platoon_leader.students.index"),
            student_columns,
            1
        );
    }

    /** Attendance Monitoring */
    if ( window.location.href === route("platoon_leader.attendance-monitoring.index")) {
        const columns = [
            {
                data: "id",
                render(data, type, row) {
                    return row.DT_RowIndex;
                },
            },
            { data: "description" },
            {
                data: "created_at",
                render(data) {
                    return formatDate(data, "datetime");
                },
            },
        ];
        c_index(
            $(".attendance_dt"),
            route("platoon_leader.attendance-monitoring.index"),
            columns
        );
    }

    /** Attendance Report */
    if (window.location.href === route("platoon_leader.attendances.index")) {
        const columns = [
            {
                data: "id",
                render(data, type, row) {
                    return row.DT_RowIndex;
                },
            },
            { data: "student_id" },
            { data: "student" },
            { data: "schedule" },
            {
                data: "date_time_in",
                render(data) {
                    return data ?? "";
                },
            },
            {
                data: "date_time_out",
                render(data) {
                    return data ?? "";
                },
            },
            { data: "status" },
        ];
        c_index(
            $(".attendance_dt"),
            route("platoon_leader.attendances.index"),
            columns
        );
    }

    // Student Performance
    if (window.location.href === route("platoon_leader.performances.index")) {
        const columns = [
            {
                data: "id",
                render(data, type, row) {
                    return row.DT_RowIndex;
                },
            },
            { data: "student_id" },
            { data: "student" },
            { data: "course" },
            { data: "type" },
            { data: "points" },
            { data: "remark" },
            {
                data: "created_at",
                render(data) {
                    return formatDate(data, "datetime");
                },
            },

            { data: "actions", orderable: false, searchable: false },
        ];
        c_index(
            $(".performance_dt"),
            route("platoon_leader.performances.index"),
            columns,1
        );
    }

    // Student Attendance Records
    if (window.location.href === route("platoon_leader.attendance-records.index")) {

        let obj = [{
            student_id: ""
        }];

        const attendance_records_columns = [
           
            {
                data: "id",
                render(data, type, row, meta) {
                    return row.DT_RowIndex;
                },
            },
            {
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
                data: "day_one",
                render(data) {
                    if (data == 0 || data==null) {
                        return data;
                    }else{
                        return data;
                    }
                },
            },
            {
                data: "day_two",
                render(data) {
                    if (data == 0 || data==null) {
                        return data;
                    }else{
                        return data;
                    }
                },
            },
            {
                data: "day_three",
                render(data) {
                    if (data == 0 || data==null) {
                        return data;
                    }else{
                        return data;
                    }
                },
            },
            {
                data: "day_four",
                render(data) {
                    if (data == 0 || data==null) {
                        return data;
                    }else{
                        return data;
                    }
                },
            },
            {
                data: "day_five",
                render(data) {
                    if (data == 0 || data==null) {
                        return data;
                    }else{
                        return data;
                    }
                },
            },
            {
                data: "day_six",
                render(data) {
                    if (data == 0 || data==null) {
                        return data;
                    }else{
                        return data;
                    }
                },
            },
            {
                data: "day_seven",
                render(data) {
                    if (data == 0 || data==null) {
                        return data;
                    }else{
                        return data;
                    }
                },
            },
            {
                data: "day_eight",
                render(data) {
                    if (data == 0 || data==null) {
                        return data;
                    }else{
                        return data;
                    }
                },
            },
            {
                data: "day_nine",
                render(data) {
                    if (data == 0 || data==null) {
                        return data;
                    }else{
                        return data;
                    }
                },
            },
            {
                data: "day_ten",
                render(data) {
                    if (data == 0 || data==null) {
                        return data;
                    }else{
                        return data;
                    }
                },
            },
            {
                data: "day_eleven",
                render(data) {
                    if (data == 0 || data==null) {
                        return data;
                    }else{
                        return data;
                    }
                },
            },
            {
                data: "day_twelve",
                render(data) {
                    if (data == 0 || data==null) {
                        return data;
                    }else{
                        return data;
                    }
                },
            },
            {
                data: "day_thirtheen",
                render(data) {
                    if (data == 0 || data==null) {
                        return data;
                    }else{
                        return data;
                    }
                },
            },
            {
                data: "day_fourtheen",
                render(data) {
                    if (data == 0 || data==null) {
                        return data;
                    }else{
                        return data;
                    }
                },
            },
            {
                data: "day_fiftheen",
                render(data) {
                    if (data == 0 || data==null) {
                        return data;
                    }else{
                        return data;
                    }
                },
            },
    
            {
                data: "total_points",
                render(data) {
                    if (data =="" || data==null) {
                        return data;
                    }else{
                        return data;
                    }
                },
            },
            {
                data: "average",
                render(data) {
                    if (data=="" || data==null) {
                        return data + ".0";
                    }else{
                        return data + ".0";
                    }
                },
            },
            {
                data: "percentage_record",
                render(data) {
                    if (data=="" || data==null) {
                        return data + "%";
                    }else{
                        return data + "%";
                    }
                },
            },



           
            // {
            //     data: "student_id",
            //     render(data) {
            //         return data;
            //     },
            // },
            // {
            //     data: "student",
            //     render(data) {
            //         return data;
            //     },
            // },
            // {
            //     data: "attendance_records",
            //     render(data) {
            //         return data[0]['day_two'];
            //     },
            // },
            // {
            //     data: "attendance_records",
            //     render(data) {
            //         return data[0]['day_two'];
            //     },
            // },
            // {
            //     data: "attendance_records",
            //     render(data) {
            //         return data[0]['day_two'];
            //     },
            // },
            // {
            //     data: "attendance_records",
            //     render(data) {
            //         return data[0]['day_two'];
            //     },
            // },
            // {
            //     data: "attendance_records",
            //     render(data) {
            //         return data[0]['day_two'];
            //     },
            // },
            // {
            //     data: "attendance_records",
            //     render(data) {
            //         return data[0]['day_two'];
            //     },
            // },
            // {
            //     data: "attendance_records",
            //     render(data) {
            //         return data[0]['day_two'];
            //     },
            // },
            // {
            //     data: "attendance_records",
            //     render(data) {
            //         return data[0]['day_two'];
            //     },
            // },
            // {
            //     data: "attendance_records",
            //     render(data) {
            //         return data[0]['day_two'];
            //     },
            // },
            // {
            //     data: "attendance_records",
            //     render(data) {
            //         return data[0]['day_two'];
            //     },
            // },
            // {
            //     data: "attendance_records",
            //     render(data) {
            //         return data[0]['day_two'];
            //     },
            // },
            // {
            //     data: "attendance_records",
            //     render(data) {
            //         return data[0]['day_two'];
            //     },
            // },
            // {
            //     data: "attendance_records",
            //     render(data) {
            //         return data[0]['day_two'];
            //     },
            // },
            // {
            //     data: "attendance_records",
            //     render(data) {
            //         return data[0]['day_two'];
            //     },
            // },
            // {
            //     data: "attendance_records",
            //     render(data) {
            //         return data[0]['day_two'];
            //     },
            // },
            // {
            //     data: "total_points",
            //     render(data) {
            //         if (data) {
            //             return data;
            //         } else {
            //             return 0;
            //         }
            //     },
            // },
            // {
            //     data: "average",
            //     render(data) {
            //         if (data) {
            //             return data;
            //         } else {
            //             return 0;
            //         }
            //     },
            // },
            // {
            //     data: "percentage_record",
            //     render(data) {
            //         if (data == "" || data == null) {
            //             return "0%";
            //         } else {
            //             return data + "%";
            //         }
            //     },
            // },
        ];


        c_index(
            $(".attendance_dt"),
            route('platoon_leader.attendance-records.index'), 
            attendance_records_columns,
            1
        );

    }

    // Student Merits and Dimerits Points
    if (window.location.href === route("platoon_leader.merits-demerits.index")) {

        let day_d = 1;
        let obj =[{student_id:""}];
        let numc = 0;
        let sy = 0;
        const merit_n_dmerit_columns = [
                {
                    data: "id",
                    render(data, type, row, meta) {
                        return row.DT_RowIndex;
                    },
                },
                {
                    data: "student_id",
                    render(data) {
                        numc=data;
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
                    data: "merits",
                    render(data) {
                        return '<input disabled type="number" value="'+data+'"  maxlength="3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" >';
                    },
                },
                {
                    data: "demerits",
                    render(data) {
                        return '<input disabled type="number" value="'+data+'" maxlength="3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">';
                    },
                },
                {
                    data: "total_points",
                    render(data) {
                        return data;
                    },
                },
                {
                    data: "percentage",
                    render(data) {
                        return data+"%";
                    },
                },
                // {
                //     data: "student_id",
                //     render(data) {
                //         return "<button class='btn btn-sm btn-primary' onclick=update_records("+data+")>UPDATE </button>";
                //     },
                // },
        ];

        c_index(
            $(".merit_n_dmerit_dt"),
            route('platoon_leader.merits-demerits.index'), 
            merit_n_dmerit_columns,
            1
        );
    }

    // Student Grade
    if (window.location.href === route("platoon_leader.studentgrade.index")) {

        let stid = 0;
        let acad = 0;
        let attendance = 0;
        let aptitude = 0;
    
        const grade_columns = [
            {
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
                data: "student",
                render(data) {
                    return data;
                },
            },
            {
                data: "attendance",
                render(data) {
                    attendance = data;
                    return "<p id='attendance-"+stid+"'>"+data+"</p>";
                },
            },
            {
                data: "aptitude",
                render(data) {
                    aptitude = data;
                    return "<p id='aptitude-"+stid+"'>"+data+"</p>";
                },
            },
            {
                data: "acad",
                render(data) {
                    acad = data;
                    return '<input id="acad-'+stid+'" value="" >';
                    // return '<input id="acad-'+stid+'" value="'+data+'" type="number">';
                },
            },
            {
                data: "grade",
                render(data) {
                    let a = parseInt(attendance) + parseInt(aptitude) + parseInt(acad);
                    if(a !== a) {
                        a = 0;
                    }
                    return a;
                },
            },
            {
                data: "student_id",
                render(data) {
                    return "<button class='btn btn-sm btn-primary' onclick=update_records("+data+")>UPDATE </button>";
                },
            },
        ];
    
        c_index(
            $(".grade_dt"),
            route('platoon_leader.studentgrade.index'), 
            grade_columns,
            1
        );

    }

    // Final Student Grade 
    if (window.location.href === route("platoon_leader.studentfinalgrade.index")) {

        let stid = 0;
        const final_grade_columns = [{
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
                data: "student",
                render(data) {
                    return data;
                },
            },
            {
                data: "grade",
                render(data) {
                    if (data) {
                        data = "<p id='grade-" + stid + "'>" + data + "</p>";
                    } else {
                        data = "-"
                    }
                    return data;
                },
            },
            {
                data: "equivalent",
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
                data: "remarks",
                render(data) {
                    let a = "";
                    if (data == "0") {
                        a += '<label>PASSED</label>';
                        // a += '<option value="0" selected>PASSED</option>';
                        // a += '<option value="1">FAILED</option>';
                        // a += '<option value="2">INCOMPLETE</option>';
                        // a += '<option value="3">DROPPED</option>';
                    } else if (data == "1") {
                        a += '<label>FAILED</label>';
                        // a += '<option value="0">PASSED</option>';
                        // a += '<option value="1" selected>FAILED</option>';
                        // a += '<option value="2">INCOMPLETE</option>';
                        // a += '<option value="3">DROPPED</option>';
                    } else if (data == "3") {
                        a += '<label>DROPPED</label>';
                    } else {
                        a += '<label>INCOMPLETE</label>';
                        // a += '<option value="0">PASSED</option>';
                        // a += '<option value="1" >FAILED</option>';
                        // a += '<option value="2" selected>INCOMPLETE</option>';
                        // a += '<option value="3" >DROPPED</option>';
                    }
                    // return '<select id=remarks-'+stid+' class="form-control">'+a+'</select>';
                    return a;
                },
            },
            // {
            //     data: "student_id",
            //     render(data) {
            //         return "<button class='btn btn-sm btn-primary' onclick=update_records("+data+")>UPDATE </button>";
            //     },
            // },
        ];

        // var table = $('.final_grade_dt').DataTable({
        //     processing: true,
        //     serverSide: true,
        //     ajax: "{{ URL::to('platoon_leader/studentfinalgrade/show') }}",
        //     columns: list_columns
        // });

        c_index(
            $(".final_grade_dt"),
            route('platoon_leader.studentfinalgrade.index'), 
            final_grade_columns,
            1
        );
        

    }

    /** End Student Management */
});

//=========================================================
// Custom Functions()

document.addEventListener("DOMContentLoaded", function (event) {
    // initiate global glightbox

    setTimeout(() => {
        GLightbox({
            selector: ".glightbox",
        });
    }, 1000);
});


function filterStudentBySemester(semester) {
    var jq_year = $("#filter_year").val();

    const student_columns = [
        {
            data: "id",
            render(data, type, row, meta) {
                return row.DT_RowIndex;
            },
        },
        {
            data: "student_id",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
        {
            data: "first_name",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
    
        {
            data: "middle_name",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
        {
            data: "last_name",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
        {
            data: "sex",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
        {
            data: "course",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
        {
            data: "created_at",
            render(data) {
                return formatDate(data, "full");
            },
        },
    
        { data: "actions", orderable: false, searchable: false },
    ];

    let obj = [{
        student_id: ""
    }];

    const attendance_records_columns = [
       
        {
            data: "id",
            render(data, type, row, meta) {
                return row.DT_RowIndex;
            },
        },
        {
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
            data: "day_one",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_two",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_three",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_four",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_five",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_six",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_seven",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_eight",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_nine",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_ten",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_eleven",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_twelve",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_thirtheen",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_fourtheen",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_fiftheen",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },

        {
            data: "total_points",
            render(data) {
                if (data =="" || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "average",
            render(data) {
                if (data=="" || data==null) {
                    return data + ".0";
                }else{
                    return data + ".0";
                }
            },
        },
        {
            data: "percentage_record",
            render(data) {
                if (data=="" || data==null) {
                    return data + "%";
                }else{
                    return data + "%";
                }
            },
        },

    ];

    let day_d = 1;
    // let obj =[{student_id:""}];
    let numc = 0;
    let sy = 0;

    const merit_n_dmerit_columns = [
            {
                data: "id",
                render(data, type, row, meta) {
                    return row.DT_RowIndex;
                },
            },
            {
                data: "student_id",
                render(data) {
                    numc=data;
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
                data: "merits",
                render(data) {
                    return '<input disabled type="number" value="'+data+'"  maxlength="3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" >';
                },
            },
            {
                data: "demerits",
                render(data) {
                    return '<input disabled type="number" value="'+data+'" maxlength="3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">';
                },
            },
            {
                data: "total_points",
                render(data) {
                    return data;
                },
            },
            {
                data: "percentage",
                render(data) {
                    return data+"%";
                },
            },
            // {
            //     data: "student_id",
            //     render(data) {
            //         return "<button class='btn btn-sm btn-primary' onclick=update_records("+data+")>UPDATE </button>";
            //     },
            // },
    ];

    let stid = 0;
    let acad = 0;
    let attendance = 0;
    let aptitude = 0;

    const grade_columns = [
        {
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
            data: "student",
            render(data) {
                return data;
            },
        },
        {
            data: "attendance",
            render(data) {
                attendance = data;
                return "<p id='attendance-"+stid+"'>"+data+"</p>";
            },
        },
        {
            data: "aptitude",
            render(data) {
                aptitude = data;
                return "<p id='aptitude-"+stid+"'>"+data+"</p>";
            },
        },
        {
            data: "acad",
            render(data) {
                acad = data;
                return '<input id="acad-'+stid+'" value="" >';
                // return '<input id="acad-'+stid+'" value="'+data+'" type="number">';
            },
        },
        {
            data: "grade",
            render(data) {
                let a = parseInt(attendance) + parseInt(aptitude) + parseInt(acad);
                if(a !== a) {
                    a = 0;
                }
                return a;
            },
        },
        {
            data: "student_id",
            render(data) {
                return "<button class='btn btn-sm btn-primary' onclick=update_records("+data+")>UPDATE </button>";
            },
        },
    ];

    // let stid = 0;
    const final_grade_columns = [{
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
            data: "student",
            render(data) {
                return data;
            },
        },
        {
            data: "grade",
            render(data) {
                if (data) {
                    data = "<p id='grade-" + stid + "'>" + data + "</p>";
                } else {
                    data = "-"
                }
                return data;
            },
        },
        {
            data: "equivalent",
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
            data: "remarks",
            render(data) {
                let a = "";
                if (data == "0") {
                    a += '<label>PASSED</label>';
                    // a += '<option value="0" selected>PASSED</option>';
                    // a += '<option value="1">FAILED</option>';
                    // a += '<option value="2">INCOMPLETE</option>';
                    // a += '<option value="3">DROPPED</option>';
                } else if (data == "1") {
                    a += '<label>FAILED</label>';
                    // a += '<option value="0">PASSED</option>';
                    // a += '<option value="1" selected>FAILED</option>';
                    // a += '<option value="2">INCOMPLETE</option>';
                    // a += '<option value="3">DROPPED</option>';
                } else if (data == "3") {
                    a += '<label>DROPPED</label>';
                } else {
                    a += '<label>INCOMPLETE</label>';
                    // a += '<option value="0">PASSED</option>';
                    // a += '<option value="1" >FAILED</option>';
                    // a += '<option value="2" selected>INCOMPLETE</option>';
                    // a += '<option value="3" >DROPPED</option>';
                }
                // return '<select id=remarks-'+stid+' class="form-control">'+a+'</select>';
                return a;
            },
        },
        // {
        //     data: "student_id",
        //     render(data) {
        //         return "<button class='btn btn-sm btn-primary' onclick=update_records("+data+")>UPDATE </button>";
        //     },
        // },
    ];

    c_index(
        $(".student_dt"),
        route("platoon_leader.students.index", { 
            semester: semester.value,
            year: jq_year,
        }),
        student_columns,
        1,
        true
    );

    c_index(
        $(".attendance_dt"),
        route('platoon_leader.attendance-records.index' , { 
            semester: semester.value,
            year: jq_year,
        }), 
        attendance_records_columns,
        1,
        true
    );

    c_index(
        $(".merit_n_dmerit_dt"),
        route('platoon_leader.merits-demerits.index' , { 
            semester: semester.value,
            year: jq_year,
        }), 
        merit_n_dmerit_columns,
        1,
        true
    );

    c_index(
        $(".grade_dt"),
        route('platoon_leader.studentgrade.index' , { 
            semester: semester.value,
            year: jq_year,
        }), 
        grade_columns,
        1,
        true
    );


    c_index(
        $(".final_grade_dt"),
        route('platoon_leader.studentfinalgrade.index', { 
            semester: semester.value,
            year: jq_year,
        }), 
        final_grade_columns,
        1,
        true
    );

}

function filterStudentByYear(year) {
    var jq_sem = $("#filter_sem").val();
    
    const student_columns = [
        {
            data: "id",
            render(data, type, row, meta) {
                return row.DT_RowIndex;
            },
        },
        {
            data: "student_id",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
        {
            data: "first_name",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
    
        {
            data: "middle_name",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
        {
            data: "last_name",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
        {
            data: "sex",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
        {
            data: "course",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
        {
            data: "created_at",
            render(data) {
                return formatDate(data, "full");
            },
        },
    
        { data: "actions", orderable: false, searchable: false },
    ];
    let obj = [{
        student_id: ""
    }];

    const attendance_records_columns = [
       
        {
            data: "id",
            render(data, type, row, meta) {
                return row.DT_RowIndex;
            },
        },
        {
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
            data: "day_one",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_two",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_three",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_four",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_five",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_six",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_seven",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_eight",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_nine",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_ten",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_eleven",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_twelve",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_thirtheen",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_fourtheen",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "day_fiftheen",
            render(data) {
                if (data == 0 || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },

        {
            data: "total_points",
            render(data) {
                if (data =="" || data==null) {
                    return data;
                }else{
                    return data;
                }
            },
        },
        {
            data: "average",
            render(data) {
                if (data=="" || data==null) {
                    return data + ".0";
                }else{
                    return data + ".0";
                }
            },
        },
        {
            data: "percentage_record",
            render(data) {
                if (data=="" || data==null) {
                    return data + "%";
                }else{
                    return data + "%";
                }
            },
        },

    ];

    let day_d = 1;
    // let obj =[{student_id:""}];
    let numc = 0;
    let sy = 0;

    const merit_n_dmerit_columns = [
            {
                data: "id",
                render(data, type, row, meta) {
                    return row.DT_RowIndex;
                },
            },
            {
                data: "student_id",
                render(data) {
                    numc=data;
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
                data: "merits",
                render(data) {
                    return '<input disabled type="number" value="'+data+'"  maxlength="3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);" >';
                },
            },
            {
                data: "demerits",
                render(data) {
                    return '<input disabled type="number" value="'+data+'" maxlength="3" oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);">';
                },
            },
            {
                data: "total_points",
                render(data) {
                    return data;
                },
            },
            {
                data: "percentage",
                render(data) {
                    return data+"%";
                },
            },
            // {
            //     data: "student_id",
            //     render(data) {
            //         return "<button class='btn btn-sm btn-primary' onclick=update_records("+data+")>UPDATE </button>";
            //     },
            // },
    ];

    let stid = 0;
    let acad = 0;
    let attendance = 0;
    let aptitude = 0;

    const grade_columns = [
        {
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
            data: "student",
            render(data) {
                return data;
            },
        },
        {
            data: "attendance",
            render(data) {
                attendance = data;
                return "<p id='attendance-"+stid+"'>"+data+"</p>";
            },
        },
        {
            data: "aptitude",
            render(data) {
                aptitude = data;
                return "<p id='aptitude-"+stid+"'>"+data+"</p>";
            },
        },
        {
            data: "acad",
            render(data) {
                acad = data;
                return '<input id="acad-'+stid+'" value="" >';
                // return '<input id="acad-'+stid+'" value="'+data+'" type="number">';
            },
        },
        {
            data: "grade",
            render(data) {
                let a = parseInt(attendance) + parseInt(aptitude) + parseInt(acad);
                if(a !== a) {
                    a = 0;
                }
                return a;
            },
        },
        {
            data: "student_id",
            render(data) {
                return "<button class='btn btn-sm btn-primary' onclick=update_records("+data+")>UPDATE </button>";
            },
        },
    ];

      // let stid = 0;
      const final_grade_columns = [{
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
        data: "student",
        render(data) {
            return data;
        },
    },
    {
        data: "grade",
        render(data) {
            if (data) {
                data = "<p id='grade-" + stid + "'>" + data + "</p>";
            } else {
                data = "-"
            }
            return data;
        },
    },
    {
        data: "equivalent",
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
        data: "remarks",
        render(data) {
            let a = "";
            if (data == "0") {
                a += '<label>PASSED</label>';
                // a += '<option value="0" selected>PASSED</option>';
                // a += '<option value="1">FAILED</option>';
                // a += '<option value="2">INCOMPLETE</option>';
                // a += '<option value="3">DROPPED</option>';
            } else if (data == "1") {
                a += '<label>FAILED</label>';
                // a += '<option value="0">PASSED</option>';
                // a += '<option value="1" selected>FAILED</option>';
                // a += '<option value="2">INCOMPLETE</option>';
                // a += '<option value="3">DROPPED</option>';
            } else if (data == "3") {
                a += '<label>DROPPED</label>';
            } else {
                a += '<label>INCOMPLETE</label>';
                // a += '<option value="0">PASSED</option>';
                // a += '<option value="1" >FAILED</option>';
                // a += '<option value="2" selected>INCOMPLETE</option>';
                // a += '<option value="3" >DROPPED</option>';
            }
            // return '<select id=remarks-'+stid+' class="form-control">'+a+'</select>';
            return a;
        },
    },
    // {
    //     data: "student_id",
    //     render(data) {
    //         return "<button class='btn btn-sm btn-primary' onclick=update_records("+data+")>UPDATE </button>";
    //     },
    // },
];

    c_index(
        $(".student_dt"),
        route("platoon_leader.students.index", { 
            semester: jq_sem,
            year: year.value,
        }),
        student_columns,
        1,
        true
    );

    c_index(
        $(".attendance_dt"),
        route('platoon_leader.attendance-records.index' , { 
            semester: jq_sem,
            year: year.value,
        }), 
        attendance_records_columns,
        1,
        true
    );

    c_index(
        $(".merit_n_dmerit_dt"),
        route('platoon_leader.merits-demerits.index' , { 
            semester: jq_sem,
            year: year.value,
        }), 
        merit_n_dmerit_columns,
        1,
        true
    );

    c_index(
        $(".grade_dt"),
        route('platoon_leader.studentgrade.index' , { 
            semester: jq_sem,
            year: year.value,
        }), 
        grade_columns,
        1,
        true
    );


    c_index(
        $(".final_grade_dt"),
        route('platoon_leader.studentfinalgrade.index', { 
            semester: jq_sem,
            year: year.value,
        }), 
        final_grade_columns,
        1,
        true
    );

}

function filterStudentByCourse(course) {
    const columns = [
        {
            data: "id",
            render(data, type, row, meta) {
                return row.DT_RowIndex;
            },
        },
        {
            data: "student_id",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
        {
            data: "first_name",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },

        {
            data: "middle_name",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
        {
            data: "last_name",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
        {
            data: "sex",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
        {
            data: "course",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
        {
            data: "created_at",
            render(data) {
                return formatDate(data, "full");
            },
        },

        { data: "actions", orderable: false, searchable: false },
    ];
    c_index(
        $(".student_dt"),
        route("platoon_leader.students.index", {
            course: course.value,
        }),
        columns,
        1,
        true
    );
}
