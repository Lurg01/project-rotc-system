const token = $('meta[name="csrf-token"]').attr("content");
const baseUrl = window.location.origin;
let pond;

$(() => {
    // Activity Logs
    if (window.location.href === route("admin.activity_logs.index")) {
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
            { data: "properties.ip" },
        ];
        c_index(
            $(".activitylog_dt"),
            route("admin.activity_logs.index"),
            columns, 1
        );
    }

    //Category;
    if (window.location.href === route("admin.categories.index")) {
        const columns = [
            {
                data: "id",
                render(data, type, row) {
                    return row.DT_RowIndex;
                },
            },
            { data: "name" },
            { data: "actions", orderable: false, searchable: false },
        ];
        c_index($(".category_dt"), route("admin.categories.index"), columns);
    }

    // Patient
    if (window.location.href === route("admin.patients.index")) {
        const columns = [
            {
                data: "id",
                render(data, type, row, meta) {
                    return row.DT_RowIndex;
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
                data: "gender",
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
        c_index($(".patient_dt"), route("admin.patients.index"), columns);
    }

    //User;
    if (window.location.href === route("admin.users.index")) {
        const columns = [
            { data: "id" },
            {
                data: "avatar",
                render(data) {
                    return handleNullAvatar(data);
                },
            },
            { data: "name" },
            {
                data: "email_verified_at",
                render(data) {
                    return isVerified(data);
                },
            },
            {
                data: "role",
                render(data) {
                    return `<span class='badge badge-primary'>${data}</span>`;
                },
            },
            {
                data: "is_activated",
                render(data) {
                    return isActivated(data);
                },
            },
            {
                data: "created_at",
                render(data) {
                    return formatDate(data.date, "full");
                },
            },
            { data: "actions", orderable: false, searchable: false },
        ];
        c_index($(".user_dt"), route("admin.users.index"), columns, 1);
    }

    /** Start Student Management */

    //Platoon;
    if (window.location.href === route("admin.platoons.index")) {
        const columns = [
            {
                data: "id",
                render(data, type, row) {
                    return row.DT_RowIndex;
                },
            },
            { data: "name" },
            { data: "actions", orderable: false, searchable: false },
        ];
        c_index($(".platoon_dt"), route("admin.platoons.index"), columns);
    }

    // Department
    if (window.location.href === route("admin.departments.index")) {
        const columns = [
            {
                data: "id",
                render(data, type, row) {
                    return row.DT_RowIndex;
                },
            },
            { data: "name" },
            { data: "abbreviation" },
            { data: "actions", orderable: false, searchable: false },
        ];
        c_index($(".department_dt"), route("admin.departments.index"), columns);
    }

    // Course
    if (window.location.href === route("admin.courses.index")) {
        const column_data = [
            {
                data: "id",
                render(data, type, row) {
                    return row.DT_RowIndex;
                },
            },
            { data: "name" },
            { data: "abbreviation" },
            {
                data: "department",
                render(data) {
                    return `<span class='text-capitalize'>${data.name}</span>`;
                },
            },

            { data: "actions", orderable: false, searchable: false },
        ];
        c_index($(".course_dt"), route("admin.courses.index"), column_data);
    }

    // Student
    if (window.location.href === route("admin.students.index")) {
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
                data: "platoon",
                render(data) {
                    return `<span class='text-capitalize'>${data}</span>`;
                },
            },
            {
                data: "semester",
                render(data) {
                    if (data) {
                        if (data == "1") {
                            data = "1st Sem";
                        }
                        else if (data == "2") {
                            data = "2nd Sem";
                        }
                    }
                    return data;
                },
            },
            {
                data: "status",
                render(data) {
                    if (data == 0) {
                        return `<span class='text-capitalize'>Active</span>`;
                    }
                    return `<span class='text-capitalize'>Active</span>`;
                },
            },

            { data: "actions", orderable: false, searchable: false },
        ];
        c_index($(".student_dt"), route("admin.students.index"), columns, 1);
    }

    // Attendance Records
    if (window.location.href === route("admin.attendance-records.index")) {
        const list_columns = [
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

            // { data: "actions", orderable: false, searchable: false },
        ];

        c_index($(".attendance_dt"), route('admin.attendance-records.index'), list_columns, 1 );
    }

    // Aptitude
    if (window.location.href === route("admin.aptitude.index")) {  

          let day_d = 1;
        let obj = [{
            student_id: ""
        }];
        let numc = 0;
        let sy = 0;
        const aptitude_columns = [{
            data: "student_id",
            render(data) {
                numc = data;
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
                return data;
            },
        },
        {
            data: "demerits",
            render(data) {
                return data;
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
                return data + "%";
            },
        },
        // {
        //     data: "student_id",
        //     render(data) {
        //         return "<button class='btn btn-sm btn-primary' onclick=update_records("+data+")>UPDATE </button>";
        //     },
        // },
        ];

        c_index($(".aptitude_dt"), route("admin.aptitude.index"), aptitude_columns, 1);

    }

    // Student Grade 
    if (window.location.href == route("admin.studentgrade.index")) {
        let stid = 0;
        let acad = 0;
        let attendance = 0;
        let aptitude = 0;
    
        const grade_columns = [{
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
            route("admin.studentgrade.index"),
            grade_columns,
            1
        );
    }

    // Final Student Grade
    if (window.location.href == route("admin.finalstudentgrade.index")) {
  
        let stid = 0;
        let acad = 0;
        let attendance = 0;
        let aptitude = 0;

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
            route("admin.finalstudentgrade.index"),
            final_grade_columns,
            1
        );

    }

    /** Attendance Report */
    if (window.location.href === route("admin.attendances.index")) {
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
        c_index($(".attendance_dt"), route("admin.attendances.index"), columns, 1);
    }

    // Student Performance

    if (window.location.href === route("admin.performances.index")) {
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
            route("admin.performances.index"),
            columns
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

function filterStudentByPlatoon(platoon) {
    var jq_sem = $("#filter_sem").val();
    var jq_year = $("#filter_year").val();

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
            data: "platoon",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
        {
            data: "semester",
            render(data) {
                if (data) {
                    if (data == "1") {
                        data = "1st Sem";
                    }
                    else if (data == "2") {
                        data = "2nd Sem";
                    }
                }
                return data;
            },
        },
        {
            data: "status",
            render(data) {
                if (data == 0) {
                    return `<span class='text-capitalize'>Active</span>`;
                }
                return `<span class='text-capitalize'>Active</span>`;
            },
        },

        { data: "actions", orderable: false, searchable: false },
    ];
    const list_columns = [
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

    // { data: "actions", orderable: false, searchable: false },
    ];
    const aptitude_columns = [{
        data: "student_id",
        render(data) {
            numc = data;
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
            return data;
        },
    },
    {
        data: "demerits",
        render(data) {
            return data;
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
            return data + "%";
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

    const grade_columns = [{
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

    // let stid = 0;
    // let acad = 0;
    // let attendance = 0;
    // let aptitude = 0;

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
        $(".student_dt"),
        route("admin.students.index", {
            platoon: platoon.value,
            semester: jq_sem,
            year: jq_year,
        }),
        columns,
        1,
        true
    );
    c_index(
        $(".attendance_dt"),
        route("admin.attendance-records.index", {
            platoon: platoon.value,
            semester: jq_sem,
            year: jq_year,
        }),
        list_columns,
        1,
        true
    );
    c_index(
        $(".aptitude_dt"),
        route("admin.aptitude.index", { 
            platoon: platoon.value,
            semester: jq_sem,
            year: jq_year,
        }),
        aptitude_columns,
        1,
        true
    );
    c_index(
        $(".grade_dt"),
        route("admin.studentgrade.index", { 
            platoon: platoon.value,
            semester: jq_sem,
            year: jq_year,
        }),
        grade_columns,
        1,
        true
    );
    c_index(
        $(".final_grade_dt"),
        route("admin.finalstudentgrade.index", { 
            platoon: platoon.value,
            semester: jq_sem,
            year: jq_year,
        }),
        final_grade_columns,
        1,
        true
    );

}

function filterStudentBySemester(semester) {
    var jq_platoon = $("#filter_platoon").val();
    var jq_year = $("#filter_year").val();

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
            data: "platoon",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
        {
            data: "semester",
            render(data) {
                if (data) {
                    if (data == "1") {
                        data = "1st Sem";
                    }
                    else if (data == "2") {
                        data = "2nd Sem";
                    }
                }
                return data;
            },
        },
        {
            data: "status",
            render(data) {
                if (data == 0) {
                    return `<span class='text-capitalize'>Active</span>`;
                }
                return `<span class='text-capitalize'>Active</span>`;
            },
        },

        { data: "actions", orderable: false, searchable: false },
    ];
    const list_columns = [
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
    
        // { data: "actions", orderable: false, searchable: false },
    ];
    const aptitude_columns = [{
        data: "student_id",
        render(data) {
            numc = data;
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
            return data;
        },
    },
    {
        data: "demerits",
        render(data) {
            return data;
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
            return data + "%";
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

    const grade_columns = [{
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
        $(".student_dt"),
        route("admin.students.index", {
            platoon: jq_platoon,
            semester: semester.value,
            year: jq_year,
        }),
        columns,
        1,
        true
    );
    c_index(
        $(".attendance_dt"),
        route("admin.attendance-records.index", {
            platoon: jq_platoon,
            semester: semester.value,
            year: jq_year,
        }),
        list_columns,
        1,
        true
    );
    c_index(
        $(".aptitude_dt"),
        route("admin.aptitude.index", { 
            platoon: jq_platoon,
            semester: semester.value,
            year: jq_year,
        }),
        aptitude_columns,
        1,
        true
    );
    c_index(
        $(".grade_dt"),
        route("admin.studentgrade.index", { 
            platoon: jq_platoon,
            semester: semester.value,
            year: jq_year,
        }),
        grade_columns,
        1,
        true
    );
    c_index(
        $(".final_grade_dt"),
        route("admin.finalstudentgrade.index", { 
            platoon: jq_platoon,
            semester: semester.value,
            year: jq_year,
        }),
        final_grade_columns,
        1,
        true
    );

}

function filterStudentByYear(year) {
    var jq_platoon = $("#filter_platoon").val();
    var jq_sem = $("#filter_sem").val();

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
            data: "platoon",
            render(data) {
                return `<span class='text-capitalize'>${data}</span>`;
            },
        },
        {
            data: "semester",
            render(data) {
                if (data) {
                    if (data == "1") {
                        data = "1st Sem";
                    }
                    else if (data == "2") {
                        data = "2nd Sem";
                    }
                }
                return data;
            },
        },
        {
            data: "status",
            render(data) {
                if (data == 0) {
                    return `<span class='text-capitalize'>Active</span>`;
                }
                return `<span class='text-capitalize'>Active</span>`;
            },
        },

        { data: "actions", orderable: false, searchable: false },
    ];
    const list_columns = [
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
    
        // { data: "actions", orderable: false, searchable: false },
    ];
    const aptitude_columns = [{
        data: "student_id",
        render(data) {
            numc = data;
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
            return data;
        },
    },
    {
        data: "demerits",
        render(data) {
            return data;
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
            return data + "%";
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

    const grade_columns = [{
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
        $(".student_dt"),
        route("admin.students.index", {
            platoon: jq_platoon,
            semester: jq_sem,
            year: year.value,
        }),
        columns,
        1,
        true
    );
    c_index(
        $(".attendance_dt"),
        route("admin.attendance-records.index", {
            platoon: jq_platoon,
            semester: jq_sem,
            year: year.value,
        }),
        list_columns,
        1,
        true
    );
    c_index(
        $(".aptitude_dt"),
        route("admin.aptitude.index", { 
            platoon: jq_platoon,
            semester: jq_sem,
            year: year.value,
        }),
        aptitude_columns,
        1,
        true
    );
    c_index(
        $(".grade_dt"),
        route("admin.studentgrade.index", { 
            platoon: jq_platoon,
            semester: jq_sem,
            year: year.value,
        }),
        grade_columns,
        1,
        true
    );
    c_index(
        $(".final_grade_dt"),
        route("admin.finalstudentgrade.index", { 
            platoon: jq_platoon,
            semester: jq_sem,
            year: year.value,
        }),
        final_grade_columns,
        1,
        true
    );

}



