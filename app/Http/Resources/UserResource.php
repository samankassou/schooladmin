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
            'id' => $this->id,
            'avatar' => empty($this->avatar) ? asset('images/default-user.jpg'): asset($this->avatar->getUrl('avatar-thumb')),
            'name' => $this->name,
            'status' => $this->status,
            'email' => $this->email
        ];
    }
}
