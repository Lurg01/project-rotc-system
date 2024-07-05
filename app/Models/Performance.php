<?php

namespace App\Models;

use App\Traits\BelongsToStudent;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
class Performance extends Model
{
    use 
    BelongsToStudent,
    HasFactory;
    protected $table = 'performances';
    protected $fillable = [
        'student_id',
        'type',
        'points',
        'remark'
    ];

    public function students(): HasOne
    {
        return $this->hasOne(Student::class,'id', 'student_id');
    }
}