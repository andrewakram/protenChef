<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UsersResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    protected $token;

    public function token($value)
    {
        $this->token = $value;
        return $this;
    }


    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'image' => $this->image,
            'gender' => $this->gender,
            'age' => $this->age,
            'weight' => $this->weight,
            'height' => $this->height,
            'provider' => $this->provider ? $this->provider : "",
            'social_id' => $this->social_id ? $this->social_id : "",
            'token' => $this->token ? $this->token : "",
            'is_completed' => $this->age ? 1 : 0

        ];
    }


}
