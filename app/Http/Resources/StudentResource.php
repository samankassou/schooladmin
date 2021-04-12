<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentResource extends JsonResource
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
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'dob' => $this->dob,
            'place_of_birth' => $this->place_of_birth,
            'classroom' => new ClassroomResource($this->current_classroom)
        ];
    }
}
