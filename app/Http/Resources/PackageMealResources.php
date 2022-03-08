<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageMealResources extends JsonResource
{

    private static $dates;

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
            'title' => $this->Meal->title,
            'day' => $this->day, //Sunday
            'date' => $this->date, //1   //2
            'week' => $this->week, //1   //2
            'image' => $this->Meal->Image->image,
            'selected' => in_array($this->date, self::$dates) ? 1 : 0,

        ];
        if (($key = array_search($this->date, self::$dates)) !== false) {
            unset(self::$dates[$key]);
        }

        return $data;


    }

    public static function customCollection($resource, $dates): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {

        //you can add as many params as you want.
        self::$dates = $dates;
        return parent::collection($resource);
    }


}
