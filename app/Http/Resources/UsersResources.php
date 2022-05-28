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
            'id' => (int) $this->id,
            'name' => (string) $this->name ? $this->name : "",
            'email' =>(string) $this->email ?$this->email :"",
            'phone' =>(string) $this->phone ?$this->phone :"",
            'image' =>(string) $this->image,
            'gender' =>(string) $this->gender ?$this->gender : "",
            'age' => (integer)$this->age ? $this->age : 0,
            'weight' => (double)$this->weight ? $this->weight : 0.0,
            'height' => (double)$this->height ? $this->height : 0.0,
            'provider' => $this->provider ? $this->provider : "",
            'social_id' => $this->social_id ? $this->social_id : "",
            'token' => $this->token ? $this->token : "",
            'is_completed' => $this->age ? 1 : 0

        ];
    }


}
