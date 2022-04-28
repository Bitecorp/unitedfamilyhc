<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ContactEmergencyResource extends JsonResource
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
            'user_id' => $this->user_id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'mi' => $this->mi,
            'street_addres' => $this->street_addres,
            'apartment_unit' => $this->apartment_unit,
            'city' => $this->city,
            'state' => $this->state,
            'zip_code' => $this->zip_code,
            'home_phone' => $this->home_phone,
            'alternate_phone' => $this->alternate_phone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
