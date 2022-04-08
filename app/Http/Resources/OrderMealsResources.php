<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderMealsResources extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'meal_id' =>$this->Meal ? $this->Meal->id : null,
            'status' => $this->status,
            'title' => $this->meal_title,
            'image' => $this->Meal ? $this->Meal->Image->image : asset('uploads/default.png'),
            'date' => Carbon::parse($this->date)->translatedFormat('d/m/Y l'),

        ];
    }
}
