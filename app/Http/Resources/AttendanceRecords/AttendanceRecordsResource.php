<?php

namespace App\Http\Resources\AttendanceRecords;

use Illuminate\Http\Resources\Json\JsonResource;

class AttendanceRecordsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [

            'student' => $this->students->full_name,
            'student_id' => $this->students->student_id,
            'day_one' => $this->day_one,
            'day_two' => $this->day_two,
            'day_three' => $this->day_three, 
            'day_four' => $this->day_four, 
            'day_five' => $this->day_five,
            'day_six' => $this->day_six,
            'day_seven' => $this->day_seven,
            'day_eight' => $this->day_eight,
            'day_nine' => $this->day_nine,
            'day_ten' => $this->day_ten,
            'day_eleven' => $this->day_eleven,
            'day_twelve' => $this->day_twelve,
            'day_thirtheen' => $this->day_thirtheen,
            'day_fourtheen' => $this->day_fourtheen,
            'day_fiftheen' => $this->day_fiftheen,
            'total_points' => $this->total_points,
            'average' => $this->average,
            'percentage_record' => $this->percentage_record,
        ];
    }
}
