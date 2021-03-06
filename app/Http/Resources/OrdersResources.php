<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrdersResources extends JsonResource
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
            'order_num' => $this->order_num,
            'package_name' => \app()->getLocale() == "ar" ? $this->package_name_ar : $this->package_name_en,
            'package_type' => \app()->getLocale() == "ar" ? $this->package_type_ar : $this->package_type_en,
            'meals_count' => $this->OrderMeals->groupBy('date')->count(),
            'delivered_meals_count' => $this->DeliveredOrderMeals->groupBy('date')->count(),
            'status' => $this->status,
        ];
    }
}
