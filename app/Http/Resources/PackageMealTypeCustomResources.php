<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageMealTypeCustomResources extends JsonResource
{
    private static $meal_type_id = 1;

    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // if the meal type id selected is the same current record meal type id will be selected in ui
        if($this->price == null){
            $price = 0 ;
        }else{
            $price = $this->price ;
        }
        if(self::$meal_type_id == $this->meal_type_id){
            $data = [
                'id' => $this->id,
                'meal_type_id' => $this->meal_type_id,
                'title' => $this->MealType->title,
                'image' => $this->MealType->image,
                'price' => (string)$price,
                'selected' =>  1,
            ];
        }else{
            $data = [
                'id' => $this->id,
                'meal_type_id' => $this->meal_type_id,
                'title' => $this->MealType->title,
                'image' => $this->MealType->image,
                'price' => (string)$price,
                'selected' =>  0,
            ];
        }
        return $data;
    }


    public static function customCollection($resource, $meal_type_id): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {

        //you can add as many params as you want.
        self::$meal_type_id = $meal_type_id;
        return parent::collection($resource);
    }
}
