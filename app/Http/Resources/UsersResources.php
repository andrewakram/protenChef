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
            'name' => $this->name ? $this->name : "",
            'email' => $this->email ?$this->email :"",
            'phone' => $this->phone ?$this->phone :"",
            'image' => $this->image,
            'gender' => $this->gender ?$this->gender : "",
            'age' => $this->age ?$this->age : 0,
            'weight' => $this->weight ? $this->weight : 0.0,
            'height' => $this->height ? $this->height : 0.0,
            'provider' => $this->provider ? $this->provider : "",
            'social_id' => $this->social_id ? $this->social_id : "",
            'token' => $this->token ? $this->token : "",
            'is_completed' => $this->age ? 1 : 0

        ];
    }


}
