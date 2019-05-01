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
            "address_id" => $this->address->id,
            "address_name" => $this->address->name,
            "specialist_id" => $this->specialist->id,
            "specialist_name" => $this->specialist->name,
            "sub_specialist_id" => $this->sub_specialist->id,
            "sub_specialist_name" => $this->sub_specialist->name,
            "hospital_name" => $this->hospital_name,
            "address_details" => $this->address_details,
            "longtatude" => $this->longtatude,
            "latitude" => $this->latitude,
            "employee_id" => $this->employee->id,
            "employee_name" => $this->employee->name,
            "rating" => $this->rating,
            "review" => $this->ratings,
            "actived" => $this->actived,
            "title" => $this->title,
            "experience" => $this->experience,
        ];
    }
}
