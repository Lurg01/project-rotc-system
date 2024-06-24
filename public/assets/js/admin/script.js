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
                    if (data == null) {
                        data = "1st Sem";
                    }
                    else if (data == "1") {
                        data = "1st Sem";
                    }
                    else if (data == "2") {
                        data = "2nd Sem";
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
    if (window.location.href === route("admin.attendance-records.records")) {
        const list_columns = [
  
            {
                data: "student_id",
                render(data) {
                    return data;
                },
            },
            {
                data: "student",
                render(data) {
                    return data ;
                },
            },
            {
                data: "day_one",
                render(data) {
                    if (data=="" || data==null) {
                        return "0";
                    }else{
                        return "1";
                    }
                },
            },
            {
                data: "day_two",
                render(data) {
                    if (data=="" || data==null) {
                        return "0";
                    }else{
                        return "1";
                    }
                },
            },
            {
                data: "day_three",
                render(data) {
                    if (data=="" || data==null) {
                        return "0";
                    }else{
                        return "1";
                    }
                },
            },
            {
                data: "day_four",
                render(data) {
                    if (data=="" || data==null) {
                        return "0";
                    }else{
                        return "1";
                    }
                },
            },
            {
                data: "day_five",
                render(data) {
                    if (data=="" || data==null) {
                        return "0";
                    }else{
                        return "1";
                    }
                },
            },
            {
                data: "day_six",
                render(data) {
                    if (data=="" || data==null) {
                        return "0";
                    }else{
                        return "1";
                    }
                },
            },
            {
                data: "day_seven",
                render(data) {
                    if (data=="" || data==null) {
                        return "0";
                    }else{
                        return "1";
                    }
                },
            },
            {
                data: "day_eight",
                render(data) {
                    if (data=="" || data==null) {
                        return "0";
                    }else{
                        return "1";
                    }
                },
            },
            {
                data: "day_nine",
                render(data) {
                    if (data=="" || data==null) {
                        return "0";
                    }else{
                        return "1";
                    }
                },
            },
            {
                data: "day_ten",
                render(data) {
                    if (data=="" || data==null) {
                        return "0";
                    }else{
                        return "1";
                    }
                },
            },
            {
                data: "day_eleven",
                render(data) {
                    if (data=="" || data==null) {
                        return "0";
                    }else{
                        return "1";
                    }
                },
            },
            {
                data: "day_twelve",
                render(data) {
                    if (data=="" || data==null) {
                        return "0";
                    }else{
                        return "1";
                    }
                },
            },
            {
                data: "day_thirtheen",
                render(data) {
                    if (data=="" || data==null) {
                        return "0";
                    }else{
                        return "1";
                    }
                },
            },
            {
                data: "day_fourtheen",
                render(data) {
                    if (data=="" || data==null) {
                        return "0";
                    }else{
                        return "1";
                    }
                },
            },
            {
                data: "day_fiftheen",
                render(data) {
                    if (data=="" || data==null) {
                        return "0";
                    }else{
                        return "1";
                    }
                },
            },
    
            {
                data: "total_points",
                render(data) {
                    if (data=="" || data==null) {
                        return "0";
                    }else{
                        return data;
                    }
                },
            },
            {
                data: "average",
                render(data) {
                    if (data=="" || data==null) {
                        return "0.0";
                    }else{
                        return data+".0";
                    }
                },
            },
            {
                data: "percentage_record",
                render(data) {
                    if (data=="" || data==null) {
                        return "0%";
                    }else{
                        return data+"%";
                    }
                },
            },

            // { data: "actions", orderable: false, searchable: false },
        ];

        c_index($(".attendance_dt"), route('admin.attendance-records.records'), list_columns, 1
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
function filterAttendanceRecordsByPlatoon(platoon) {

    const list_columns = [
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
            data: "full_day",
            render(data) {
                let cleardata = data.split(" ").join("");
                const ar = cleardata.split("-");
                if (ar[1] == 0 || ar[1] == "") {
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
                if (ar[15] == 0 || ar[15] == "") {
                    return "0";
                } else {
                    return "1";
                }
            },
        },

        {
            data: "total_points",
            render(data) {
                if (data=="" || data==null) {
                    return "0";
                }else{
                    return data;
                }
            },
        },
        {
            data: "average",
            render(data) {
                if (data=="" || data==null) {
                    return "0.0";
                }else{
                    return data+".0";
                }
            },
        },
        {
            data: "percentage_record",
            render(data) {
                if (data=="" || data==null) {
                    return "0%";
                }else{
                    return data+"%";
                }
            },
        },
        { data: "actions", orderable: false, searchable: false },
    ];
    var jq_sem = $("#filter_sem").val();
    var jq_year = $("#filter_year").val();

    c_index(
        $(".attendance_dt"),
        route("admin.records"),
        list_columns,
        1,
        true
    );
}


function filterStudentByPlatoon(platoon) {
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
    var jq_sem = $("#filter_sem").val();
    var jq_year = $("#filter_year").val();
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
}

function filterStudentByYear(year) {
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
    var jq_platoon = $("#filter_platoon").val();
    var jq_sem = $("#filter_sem").val();
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
}

function filterStudentBySemester(semester) {
    console.log(semester.value);
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
    var jq_sem = $("#filter_platoon").val();
    var jq_year = $("#filter_year").val();
    c_index(
        $(".student_dt"),
        route("admin.students.index", {
            platoon: jq_sem,
            semester: semester.value,
            year: jq_year,
        }),
        columns,
        1,
        true
    );
}
