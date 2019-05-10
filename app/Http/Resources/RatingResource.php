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
            'doctor_id' => empty($this->doctor) ? null : $this->doctor->id,
            'doctor_name' => empty($this->doctor) ? null : $this->doctor->name,
            'patient_id' => empty($this->patient) ? null : $this->patient->id,
            'patient_name' => empty($this->patient) ? null : $this->patient->id,
            'patient_avatar' => empty($this->patient) ? null : $this->patient->avatar,
            'like' => empty($this->like) ? 0 : $this->like,
            'report' => empty($this->report) ? 0 : $this->report,
            'created_at' => date_format($this->created_at, 'Y-m-d H:i:s'),
            'updated_at' => date_format($this->updated_at, 'Y-m-d H:i:s'),
        ];
    }
}
