<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageMealResources extends JsonResource
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
            'title' => $this->Meal->title,
            'day' => $this->day, //Sunday
            'date' => $this->date, //1   //2
            'week' => $this->week, //1   //2
            'image' => $this->Meal->Image->image,
            'selected' => 0,
//            'meal_date' => $meal_date,
        ];
    }


}
