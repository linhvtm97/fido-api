<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RatingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'star' => $this->star,
            'review' => $this->review,
            'doctor_id' => $this->doctor->id,
            'doctor_name' => $this->doctor->name,
            'patient_id' => $this->patient->id,
            'patient_name' => $this->patient->name,
            'patient_avatar' => $this->patient->avatar,
            'like' => empty($this->like) ? 0 : $this->like,
            'report' => empty($this->report) ? 0 : $this->report,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
