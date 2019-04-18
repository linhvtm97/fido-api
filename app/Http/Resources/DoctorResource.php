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
            'data' => [
                'id' => $this->id,
                'name' => $this->name,
                'email' => $this->email,
                'description' => $this->description,
                'status' => $this->status,
                'created_by_user' => $this->created_by_user,
                'updated_by_user' => $this->updated_by_user,
                'doctor_no' =>$this->doctor_no,
                'avatar' => $this->avatar,
                'birthday' => $this->birthday,
                'gender' => $this->gender,
                'id_number' => $this->id_number,
                'id_number_place' => $this->id_number_place,
                'id_number_date' => $this->id_number_date,
                'passport_no' => $this->passport_no,
                'passport_place' => $this->passport_place,
                'passport_date' => $this->passport_date,
                'phone_no_1' => $this->phone_no_1,
                'phone_no_2' => $this->phone_no_2,
                'fk_address_id' => $this->fk_address_id,
                'fk_employee_id' => $this->fk_employee_id,
                'hospital_name' => $this->hospital_name,
                'specialist' => $this->specialist,
            ],

        ];
    }
}
