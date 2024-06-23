<?php

namespace App\Http\Resources\Performance;

use Illuminate\Http\Resources\Json\JsonResource;

class PerformanceResource extends JsonResource
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
            'id' => $this->id,
            'student_id' => $this->students->student_id,
            'student' => $this->students->full_name,
            'course' => $this->students->course->name,
            'platoon' => $this->students->platoon->name,
            'type' => $this->type,
            'points' => $this->type == 'merit' ?  " + $this->points " : " - $this->points",
            'remark' => $this->remark,
            'created_at' => $this->created_at->toDateString(),
        ];
    }
}