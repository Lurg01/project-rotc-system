<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acadgrade extends Model
{
    use HasFactory;

    protected $table = 'acadgrade';

    protected $fillable = [
        'student_id',
        'student',
        'course',
        'acad',
        'grade',
        'remarks',
        'new_stud_id',
    ];
}
