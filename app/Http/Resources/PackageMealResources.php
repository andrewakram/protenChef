<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageMealResources extends JsonResource
{
    private static $periods;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {

        $meal_date = '';
        foreach (self::$periods as $row){
            $current_Time = strtotime($row);
            $day = date("l", $current_Time);
            $selected_date = date("Y-m-d", $current_Time);
            $week_number = date('w', $current_Time);
            if($day == $this->day && $week_number == $this->week){
                $meal_date = $row;
            }
        }
        return [
            'id' => $this->id,
            'title' => $this->Meal->title,
            'day' => $this->day,
            'week' => $this->week,
            'date' => $this->week,
            'image' => $this->MealType->image,
            'meal_date' => $meal_date,
        ];
    }

    public static function customCollection($resource, $periods): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {

        //you can add as many params as you want.
        self::$periods = $periods;
        return parent::collection($resource);
    }
}
