<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            "reviews" => $this->ratings,
            "questions" => $this->questions,
        ];
    }
}
