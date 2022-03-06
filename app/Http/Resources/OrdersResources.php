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
            'package_name' => \app()->getLocale() == "ar" ? $this->package_name_ar : $this->package_name_en,
            'package_type' => \app()->getLocale() == "ar" ? $this->package_type_ar : $this->package_type_en,
            'meals_count' => $this->order_meals_count,
            'delivered_meals_count' => $this->delivered_order_meals_count,
            'status' => $this->status,
        ];
    }
}
