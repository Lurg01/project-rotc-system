@extends('layouts.platoon_leader.app')

@section('title', 'Platoon Leader | Merit and Demerit Records V2')

@section('content')
<style>
.hide{
    display:none;
}
</style>
    {{-- CONTAINER --}}
    
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div id="atn_record_alert" class="alert alert-success hide" role="alert">
                    {{ __('Successfully Updated Record') }}
                </div>
            <div>
        </div>
                <div>
                    <div class="card shadow">
                        <div class="card-body">
                            <a class="float-right btn btn-sm btn-primary me-3"
                            href="{{ route('platoon_leader.performances.create') }}">Add
                            Record +</a><br><br>
                            <div class="tab-content" id="myTabContent">
                            <div class="card">
                                        <div class="card-header">
                                            List Merits and Demerits Record
                                        </div>
                                        <div class="card-body">
                                            <div class="table-responsive">
                                                <table class="table table-hover attendance_dt">
                                                    <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Students</th>
                                                            <th>Merit</th>
                                                            <th>Demerits</th>
                                                            <th>Total Points</th>
                                                            <th>Percentage</th>
                                                            <!-- <th>Action</th> -->
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
                </div>
            </div>
        </div>
    </div>
    {{-- End CONTAINER --}}

@endsection

@section('script')
<script>
    let day_d = 1;
    let obj =[{student_id:""}];
    let numc = 0;
    let sy = 0;
    const list_columns = [
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
    
    var table = $('.attendance_dt').DataTable({
            ajax: {
                url: '{{URL::to("platoon_leader/merits-demerits/get")}}',
                type: 'GET',
            },
            stateSave: true,
            processing: true,
            serverSide: true,
            columns: list_columns
    });

    // c_index(
    //     $(".attendance_dt"),
    //     "{{URL::to("platoon_leader/merits-demerits/get")}}",
    //     list_columns,
    //     1,
    //     true
    // );
    // function update_records(record_id) {
    //     let get_merits = $("#merits-"+record_id).val();    
    //     let get_demerits = $("#demerits-"+record_id).val();    
    //     let get_semester = "-";   
    //     let get_year = "-";       

    //     var formData_dem = {
    //         day: day_d,
    //         student_id: record_id,
    //         merits: get_merits,
    //         demerits: get_demerits,
    //         semester: get_semester,
    //         year: get_year,
    //     };

    //     c_index(
    //         $(".attendance_dt"),
    //         route('platoon_leader.update_merits',formData_dem),
    //         list_columns,
    //         null,
    //         true
    //     );

    //     $("#atn_record_alert").delay(1000).fadeIn();
    //     $("#atn_record_alert").delay(3000).fadeOut();

    // }
    </script>
@endsection
