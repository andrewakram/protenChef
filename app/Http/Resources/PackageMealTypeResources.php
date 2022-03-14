<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageMealTypeResources extends JsonResource
{
    private static $key = 1;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $data = [
            'id' => $this->id,
            'title' => $this->MealType->title,
            'image' => $this->MealType->image,
            'selected' =>  self::$key,
        ];

        self::$key = 0;
        return $data;
    }
}
