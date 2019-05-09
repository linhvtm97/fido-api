<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Library\MyFunctions;

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
            'patient_address_name' => $this->patient->address->name,
            'patient_age' => MyFunctions::countAge($this->patient->birthday),
            'created_at' => date_format($this->created_at, 'Y-m-d H:i:s'),
            'updated_at' => date_format($this->updated_at, 'Y-m-d H:i:s'),
        ];
    }
}
