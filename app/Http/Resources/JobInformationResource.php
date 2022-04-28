<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class JobInformationResource extends JsonResource
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
            'title' => $this->title,
            'supervisor' => $this->supervisor,
            'work_name_location' => $this->work_name_location,
            'work_phone' => $this->work_phone,
            'salary' => $this->salary,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
