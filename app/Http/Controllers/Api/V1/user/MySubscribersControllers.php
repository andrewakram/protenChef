<?php

namespace App\Http\Controllers\Api\V1\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrdersResources;
use App\Models\Order;
use Illuminate\Http\Request;

class MySubscribersControllers extends Controller
{
    public function RecentSubscribes(Request $request){
        $user = auth()->user();
        $orders = Order::where('user_id',$user->id)
            ->whereIn('status',['pending', 'accepted'])
            ->withCount(['OrderMeals','DeliveredOrderMeals'])
            ->paginate(10);

        $data = OrdersResources::collection($orders)->response()->getData(true);
        return response()->json(msgdata($request, success(), trans('lang.success'),$data));


    }

    public function previousSubscribes(Request $request){
        $user = auth()->user();
        $orders = Order::where('user_id',$user->id)
            ->whereIn('status',['canceled', 'finished'])
            ->withCount(['OrderMeals','DeliveredOrderMeals'])
            ->paginate(10);

        $data = OrdersResources::collection($orders)->response()->getData(true);
        return response()->json(msgdata($request, success(), trans('lang.success'),$data));


    }
}
