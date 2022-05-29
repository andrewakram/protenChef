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
            'age' => (string)$this->age ? (string)$this->age : (string)0,
            'weight' => (string)$this->weight ? (string)$this->weight : (string)0.0,
            'height' => (string)$this->height ? (string)$this->height : (string)0.0,
            'provider' => $this->provider ? $this->provider : "",
            'social_id' => $this->social_id ? $this->social_id : "",
            'token' => $this->token ? $this->token : "",
            'is_completed' => $this->age ? 1 : 0

        ];
    }


}
