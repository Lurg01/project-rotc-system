<?php

namespace App\Models;

use App\Traits\BelongsToStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class AttendanceRecordsModel extends Model
{
    use
        BelongsToStudent,
        HasFactory;
    protected $table = 'attendance_records';
    // protected $fillable = [
    //     'student_id',
    //     "day_one", "day_two", "day_three", "day_four", "day_five",
    //     "day_six", "day_seven", "day_eight", "day_nine", "day_ten",
    //     "day_eleven", "day_twelve", "day_thirtheen", "day_fourtheen",
    //     "day_fiftheen", "total_points", "average", "percentage_record"
    // ];

    protected $fillable = [
        'id',
        'student',
        'student_id',
        'day_one',
        'day_two',
        'day_three', 
        'day_four', 
        'day_five',
        'day_six',
        'day_seven',
        'day_eight',
        'day_nine',
        'day_ten',
        'day_eleven',
        'day_twelve',
        'day_thirtheen',
        'day_fourtheen',
        'day_fiftheen',
        'total_points',
        'average',
        'percentage_record',
    ];

    public function students(): HasOne
    {
        return $this->hasOne(Student::class,'id', 'student_id');
    }

}
