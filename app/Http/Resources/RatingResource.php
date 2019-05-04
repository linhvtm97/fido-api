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
            'doctor_id' => $this->doctor_id,
            'patient_id' => $this->patient_id,
            'patient_name' => $this->patient_name,
            'patient_avatar' => $this->patient_avatar,
            'like' => empty($this->like) ? 0 : $this->like,
            'report' => empty($this->report) ? 0 : $this->report,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
