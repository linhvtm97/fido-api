<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Specialist;
use App\Address;
use App\Certificate;
use App\Doctor;

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
            "address" => Address::find($this->address_id)->name,
            "specialist" => Specialist::find($this->specialist_id)->name,
            "sub_specialist" => Specialist::find($this->sub_speialist_id)->name,
            "hospital_name" => $this->hospital_name,
            "address_details" => $this->address_details,
            "longtatude" => $this->longtatude,
            "latitude" => $this->latitude,
        ];
    }
}
