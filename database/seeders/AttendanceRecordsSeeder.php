<?php

namespace Database\Seeders;

use App\Models\AttendanceRecordsModel;
use App\Services\ActivityLogsService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttendanceRecordsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(ActivityLogsService $service)
    {
        $attendance_records = array(
            [
                'student' => 'Lurg',
                'student_id' => 1,
                'day_one' => 0,
                'day_two' => 0,
                'day_three' => 0, 
                'day_four' => 0, 
                'day_five' => 0,
                'day_six' => 0,
                'day_seven' => 0,
                'day_eight' => 0,
                'day_nine' => 0,
                'day_ten' => 0,
                'day_eleven' => 0,
                'day_twelve' => 0,
                'day_thirtheen' => 0,
                'day_fourtheen' => 0,
                'day_fiftheen' => 0,
                'total_points' => 0,
                'average' => 0,
                'percentage_record' => 0,
            ],
         
        );

        AttendanceRecordsModel::insert($attendance_records);

        AttendanceRecordsModel::all()->each(fn(
            $attendance_record) => $service->log_activity(model:$attendance_record, event:'added', model_name: 'AttendanceRecordsModel', model_property_name: $attendance_record->name)
        );
    }
}