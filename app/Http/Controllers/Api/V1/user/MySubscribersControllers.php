<?php

namespace App\Http\Controllers\Api\V1\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\MealTypeResources;
use App\Http\Resources\OrderAdditionResources;
use App\Http\Resources\OrderMealsResources;
use App\Http\Resources\OrdersResources;
use App\Models\MealType;
use App\Models\Order;
use App\Models\OrderAddition;
use App\Models\OrderMeal;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MySubscribersControllers extends Controller
{
    public function RecentSubscribes(Request $request)
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->withCount(['OrderMeals', 'DeliveredOrderMeals'])
            ->paginate(10);

        $data = OrdersResources::collection($orders)->response()->getData(true);
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));


    }

    public function previousSubscribes(Request $request)
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)
            ->whereIn('status', ['canceled', 'finished'])
            ->withCount(['OrderMeals', 'DeliveredOrderMeals'])
            ->paginate(10);

        $data = OrdersResources::collection($orders)->response()->getData(true);
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));

    }


    public function OrderDetails(Request $request, $id, $meal_type_id = null)
    {
        $user = auth()->user();
        $remaining_days = OrderMeal::where('order_id', $id)
            ->where('status', 'pending')
            ->count();

        $meal_types = MealType::all();
        $meal_types = MealTypeResources::collection($meal_types);
        if (!isset($meal_type_id) || $meal_type_id == null) {
            $meal_type_id = MealType::first()->id;
        }
        $order_meals = OrderMeal::where('order_id', $id)
            ->where('meal_type_id', $meal_type_id)
            ->get();

        $order_meals = OrderMealsResources::collection($order_meals);

        $order = Order::whereId($id)->first();
        $location = $order->location_body;
        $package_price = $order->package_price;
        $shipping_price = $order->shipping_price;
        $discount_price = $order->discount_price;
        $total_price = $order->total_price;
        $order_addition_prices = $order->OrderAdditions;

        $data['remaining_days'] = $remaining_days;
        $data['meal_types'] = $meal_types;
        $data['order_meals'] = $order_meals;
        $data['location'] = $location;
        $data['package_price'] = $package_price;
        $data['shipping_price'] = $shipping_price;
        $data['discount_price'] = $discount_price;
        $data['order_addition_prices'] = OrderAdditionResources::collection($order_addition_prices);
        $data['total_price'] = $total_price;
        $frozen_meals = OrderMeal::where('order_id', $id)
            ->where('old_date', '!=', null)
            ->select('id', 'date', 'old_date')
            ->get()
            ->makeHidden(['meal_title', 'meal_body']);

        $data['frozen_meals'] = $frozen_meals;

        return response()->json(msgdata($request, success(), trans('lang.success'), $data));


    }

    public function cancelOrder(Request $request, $id)
    {

        $order = Order::whereId($id)->first();

        if ($order) {
            $order->status = "canceled";
            $order->cancel_date = Carbon::now();
            $order->save();
            return response()->json(msg($request, success(), trans('lang.success')));

        }
        return response()->json(msg($request, not_found(), trans('lang.not_found')));


    }
}
