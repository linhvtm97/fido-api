<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DoctorResource extends JsonResource
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
            "id" => $this->id,
            "status" => $this->status,
            "doctor_no" => $this->doctor_no,
            "name" => $this->name,
            "avatar" => $this->avatar,
            "birthday" => $this->birthday,
            "description" => $this->description,
            "gender" => $this->gender,
            "id_number" => $this->id_number,
            "id_number_place" => $this->id_number_place,
            "id_number_date" => $this->id_number_date,
            "phone_number" => $this->phone_number,
            "email" => $this->email,
            "address_id" => empty($this->address->id) ? null : $this->address->id,
            "address_name" => empty($this->address->name) ? null : $this->address->name,
            "specialist_id" => empty($this->specialist->id) ? null : $this->specialist->id,
            "specialist_name" => empty($this->specialist->name) ? null : $this->specialist->name,
            "sub_specialist_id" => empty($this->sub_specialist->id) ? null : $this->sub_specialist->id,
            "sub_specialist_name" => empty($this->sub_specialist->name) ? null : $this->sub_specialist->name,
            "hospital_name" => $this->hospital_name,
            "office" => $this->office,
            "address_details" => $this->address_details,
            "longtatude" => $this->longtatude,
            "latitude" => $this->latitude,
            "employee_id" =>  empty($this->employee->id) ? null : $this->employee->id,
            "employee_name" => empty($this->employee->name) ? null : $this->employee->name,
            "rating" => empty($this->rating) ? 0 : $this->rating,
            "review" => new RatingCollection($this->ratings),
            "questions" => new QuestionCollection($this->questions),
            "likes" => $this->likes,
            "numberOfRating" => count($this->ratings),
            "actived" => $this->actived,
            "title" => $this->title,
            "experience" => $this->experience,
        ];
    }
}
