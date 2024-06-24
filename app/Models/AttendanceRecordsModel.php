<?php

namespace App\Models;

use App\Traits\BelongsToStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendanceRecordsModel extends Model
{
    use
        BelongsToStudent,
        HasFactory;
    protected $table = 'attendance_records';
    protected $fillable = [
        'student_id',
        "day_one", "day_two", "day_three", "day_four", "day_five",
        "day_six", "day_seven", "day_eight", "day_nine", "day_ten",
        "day_eleven", "day_twelve", "day_thirtheen", "day_fourtheen",
        "day_fiftheen", "total_points", "average", "percentage_record"
    ];
}
