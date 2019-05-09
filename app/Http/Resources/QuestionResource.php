<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QuestionResource extends JsonResource
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
            'question_content' => $this->question_content,
            'answer' => $this->answer,
            'doctor_id' => $this->doctor->id,
            'doctor_name' => $this->doctor->name,
            'doctor_avatar' => $this->doctor->avatar,
            'patient_id' => $this->patient->id,
            'patient_name' => $this->patient->name,
            'patient_avatar' => $this->patient->avatar,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
