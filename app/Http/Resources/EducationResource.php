<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EducationResource extends JsonResource
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
            'high_school' => $this->high_school,
            'college_university' => $this->college_university,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
