<?php

namespace App\Services;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Attendance;
use App\Http\Resources\Student\StudentResource;
use App\Models\AttendanceRecords;
use App\Models\AttendanceRecordsModel;
use App\Models\Message;
use DateTime;
use App\Models\Performance;

class AttendanceService  {

    // public function __construct(private TextService $service)
    // {

    // }

    public function handle(Student $student)
    {
        $current_time = time(); // the current time

        $formatted_current_time =  date('h:i A', $current_time); // the formatted current time

        $set_time_in = strtotime(getSettings()->time_in); // the settings time in
        $set_time_out = strtotime(getSettings()->time_out); // the settings time out

        $attendance = Attendance::where('student_id', $student->id)->whereDate('created_at', now())->first();

        if (is_null($attendance)) {
            // Create a new attendance record
            $attendance = new Attendance();
            $attendance->student_id = $student->id;
            $attendance->date_time_in = now();
            // Set other necessary properties
            $attendance->save();
        } else {
            if ($current_time > $set_time_in) {
                Performance::create([
                    'student_id' => $attendance->student_id,
                    'type' => 'demerit',
                    'points' => 1,
                    'remark' => 'late',
                    'created_at' => now(),
                ]);
            }
            if (is_null($attendance->date_time_in)) 
            {
                $attendance->update([
                    'date_time_in' => now(),
                    'is_late' => ($current_time > $set_time_in),
                ]);
            }
            // elseif (!is_null($attendance->date_time_in) && $current_time < $set_time_out)
            elseif (!is_null($attendance->date_time_in) && $current_time < "00:00:00")
            {
                return $this->error("Oops, $student->full_name has already - Time In - on this morning, ..", 422);
            } 
            // elseif ($current_time > $set_time_out && is_null($attendance->date_time_out)) {
            elseif ($current_time > "00:00:00" && is_null($attendance->date_time_out)) {
                $attendance->update(['date_time_out' => now()]);
                $get_AttendanceRecords = AttendanceRecordsModel::where('student_id', $student->id)->first();
                  // Initialize variables for column name and value
                $col_name_get = null;
                $col_name_val = null;
                $ttl_pnts = null;
                if(!empty($get_AttendanceRecords)) {
                    // update data
                    $days = ["day_one", "day_two", "day_three", "day_four", "day_five",
                        "day_six", "day_seven", "day_eight", "day_nine", "day_ten",
                        "day_eleven", "day_twelve", "day_thirtheen", "day_fourtheen",
                        "day_fiftheen"];
                    foreach($days as $col_name) {
                        if ($get_AttendanceRecords[$col_name] == 0) {
                            $col_name_get = $col_name;
                            $col_name_val = 1;
                            break; // Exit loop after finding the first '0'
                        }
                        if ($get_AttendanceRecords[$col_name] == 1) {
                            $ttl_pnts += $get_AttendanceRecords[$col_name];
                        }
                        
                    }
                    if ($col_name_get !== null && $col_name_val !== null) {
                        // Prepare data for update
                        $update_data  = [$col_name_get => $col_name_val,
                                        'total_points' => $ttl_pnts + 1,
                                        'average' => $ttl_pnts + 1,
                                        'percentage_record' => (($ttl_pnts + 1)  * 30) / 15];
                                        
                        // Update the attendance record
                        AttendanceRecordsModel::where('student_id', $student->id)->update($update_data);
                    }

                    // // $ttl_pnts = ['total_points' => 0];
                    // $ttl_pnts = [];
                    // foreach ($get_AttendanceRecords as $key => $value) {
                    //     // $student_attendance[$key]['total_points'] = 0;
                    //     foreach ($days as $day) { 
                    //         if ( $get_AttendanceRecords[$key][$day] == 1) {
                    //             $get_AttendanceRecords[$key]['total_points'] += $value->$day ;
                    //             $ttl_pnts = ['total_points' => $value->total_points];
                    //             AttendanceRecordsModel::where('student_id', $value->id)->update($ttl_pnts);
                    //         }
                    //     }
                    //     // AttendanceRecordsModel::where('student_id', $value->id)->update($ttl_pnts);
                    // }


                }
            } 
            else {
                return $this->error("Oops, $student->full_name has already completed his/her daily attendance for today, ..", 422);
            }
        }
        // Log attendance activity
        $message = $attendance->date_time_out ? "Time out at $formatted_current_time" : "Time in at $formatted_current_time";
        $this->log_attendance_activity($attendance, "$student->full_name, $message");
        
        // Return response
        return $this->res([
            'student' => new StudentResource($student),
            'success' => $message
        ]);
    }

    /**
     * custom attendance Logs
     *
     * @param [type] $model
     * @param [type] $message
     */
    private function log_attendance_activity($model, $message)
    {
        activity()
        ->causedBy(auth()->user())
        ->performedOn($model)
        ->withProperties(['ip' => request()->ip()])
        ->log($message);
    }

    /**
     * throw a custom response message
     *
     * @param [type] $message
     * @param integer $code
     * @return void
     */
    private function res($data)
    {
        return response()->json($data,201);
    }

    /**
     * throw a custom error message
     *
     * @param [type] $message
     * @param integer $code
     * @return void
     */
    private function error($message, $code = 401)
    {
        abort($code, $message);
    }

}
