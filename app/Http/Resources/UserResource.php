<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
                'group_id' => $this->group_id,
                'name' => $this->name,
                'email' => $this->email,
                'status' => $this->status,
                'user_active_check' => $this->user_active_check,
            ],

        ];
    }
}
