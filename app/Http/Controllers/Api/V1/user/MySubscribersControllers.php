<?php

namespace App\Http\Controllers\Api\V1\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\MealTypeResources;
use App\Http\Resources\OrderAdditionResources;
use App\Http\Resources\OrderMealsResources;
use App\Http\Resources\OrdersResources;
use App\Models\BankData;
use App\Models\Meal;
use App\Models\MealType;
use App\Models\Order;
use App\Models\OrderAddition;
use App\Models\OrderMeal;
use App\Models\PackageMeal;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class MySubscribersControllers extends Controller
{
    public function RecentSubscribes(Request $request)
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)
            ->whereIn('status', ['pending', 'accepted'])
            ->with(['OrderMeals', 'DeliveredOrderMeals'])
            ->orderBy('id', 'desc')
            ->paginate(10);
        $data = OrdersResources::collection($orders)->response()->getData(true);
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }

    public function previousSubscribes(Request $request)
    {
        $user = auth()->user();
        $orders = Order::where('user_id', $user->id)
            ->whereIn('status', ['canceled', 'finished'])
            ->withCount(['OrderMeals', 'DeliveredOrderMeals'])->orderBy('id', 'desc')
            ->paginate(10);
        $data = OrdersResources::collection($orders)->response()->getData(true);
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }


    public function OrderDetails(Request $request, $id, $meal_type_id = null)
    {
        $user = auth()->user();
        $remaining_days = OrderMeal::where('order_id', $id)
            ->where('status', 'pending')
            ->groupBy('date')
            ->count();

        if ($meal_type_id == null) {
            $selected_meal_types = OrderMeal::where('order_id', $id)->pluck('meal_type_id');
            $meal_types = MealType::whereIn('id', $selected_meal_types)->get();
        } else {
            $meal_types = MealType::all();
        }

        $meal_types = MealTypeResources::collection($meal_types);
        if (!isset($meal_type_id) || $meal_type_id == null) {
            $meal_type_id = MealType::first()->id;
        } else {
            $order = Order::whereId($id)->first();
            if (!$order) {
                return response()->json(msg($request, not_found(), trans('lang.not_found')));
            }
            $order_meals = OrderMeal::where('order_id', $id)
                ->where('meal_type_id', $meal_type_id)
                ->get();

            $order_meals = OrderMealsResources::collection($order_meals);
            $data['order_meals'] = $order_meals;
            return response()->json(msgdata($request, success(), trans('lang.success'), $data));
        }

        $order = Order::whereId($id)->first();
        if (!$order) {
            return response()->json(msg($request, not_found(), trans('lang.not_found')));
        }
        $order_meals = OrderMeal::where('order_id', $id)
            ->where('meal_type_id', $meal_type_id)
            ->get();

        $order_meals = OrderMealsResources::collection($order_meals);


        $location = $order->location_body;
        $package_price = $order->package_price;
        $package_name = $order->package_name;
        $package_id = $order->package_id;
        $package_type_id = $order->package_type_id;
        $shipping_price = $order->shipping_price;
        $discount_price = $order->discount_price;
        $total_price = $order->total_price;
        $order_addition_prices = $order->OrderAdditions;

        $status = $order->status;
        $bankData = BankData::where('order_id', $order->id)->first();
        if ($bankData && $status != "canceled") {
            $status = "order_in_cancel";
        }
        $data['order_status'] = $status;
        $data['remaining_days'] = $remaining_days;
        $data['meal_types'] = $meal_types;
        $data['order_meals'] = $order_meals;
        $data['location'] = $location;
        $working_hours_ar = Setting::where('key', "working_hours_ar")->first()->value;
        $working_hours_en = Setting::where('key', "working_hours_en")->first()->value;
        if (App::getLocale() == "ar") {
            $data['working_hours'] = $working_hours_ar;
        } else {
            $data['working_hours'] = $working_hours_en;
        }
        $data['package_price'] = $package_price;
        $data['package_name'] = $package_name;
        $data['package_id'] = $package_id;
        $data['package_type_id'] = $package_type_id;
        $data['shipping_price'] = $shipping_price;
        $data['discount_price'] = $discount_price;
        $data['order_addition_prices'] = OrderAdditionResources::collection($order_addition_prices);
        $data['total_price'] = $total_price;
        $frozen_meals = OrderMeal::where('order_id', $id)
            ->where('old_date', '!=', null)
            ->select('date', 'old_date', 'order_id')
            ->groupBy('date', 'old_date', 'order_id')
            ->get()
            ->makeHidden(['meal_title', 'meal_body'])//           ->values()
        ;

        $data['frozen_meals'] = $frozen_meals;
        $freeze_days = (int)Setting::where('key', "freeze_days")->first()->value;

        $data['remain_frozen_meals'] = $freeze_days - $frozen_meals->count();
        if (App::getLocale() == "en") {
            $company_address = Setting::where('key', 'address_en')->first();
        } else {
            $company_address = Setting::where('key', 'address_ar')->first();
        }

        $data['company_address'] = $company_address;

        return response()->json(msgdata($request, success(), trans('lang.success'), $data));


    }


    public function cancelOrder(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id',
            'iban' => 'required',
            'bank_name' => 'required',
            'name' => 'required',

        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }


        $order = Order::whereId($request->order_id)->first();

        if ($order) {
//            $order->status = "canceled";
//            $order->cancel_date = Carbon::now();
//            $order->save();


            $bank_data = BankData::where('order_id', $order->id)->first();
            if (!$bank_data) {

                BankData::create(
                    [
                        'order_id' => $order->id,
                        'iban' => $request->iban,
                        'bank_name' => $request->bank_name,
                        'name' => $request->name,
                    ]);
                return response()->json(msg($request, success(), trans('lang.success')));
            } else {

                $bank_data->iban = $request->iban;
                $bank_data->bank_name = $request->bank_name;
                $bank_data->name = $request->name;
                $bank_data->save();


                return response()->json(msg($request, success(), trans('lang.order_in_cancelled_request')));
            }

        }
        return response()->json(msg($request, not_found(), trans('lang.not_found')));


    }


    public function OrderDays(Request $request, $id)
    {
        $order_days = Order::whereId($id)->with('OrderMeals', function ($q) {
            $q->where('status', 'pending');
        })->first();

        if (!$order_days) {
            return response()->json(msg($request, success(), trans('lang.noOrderMeals')));
        }
        $dates = [];
        foreach ($order_days->OrderMeals as $orderMeal) {
            if (!in_array($orderMeal->date, $dates)) {
                array_push($dates, $orderMeal->date);
            }

        }

        $old_dates = $dates;
        $today = Carbon::now()->format('Y-m-d');
        $tomorrow = Carbon::now()->addDay()->format('Y-m-d');


        if (($key = array_search($today, $old_dates)) !== false) {
            unset($old_dates[$key]);
        }
        if (($key = array_search($tomorrow, $old_dates)) !== false) {
            unset($old_dates[$key]);
        }

//        TODO
        //sort array

        $dates = collect($old_dates)->values();
        $sorted = $dates->sort();
        $dates = $sorted->values()->all();


        return response()->json(msgdata($request, success(), trans('lang.success'), $dates));


    }


    public function freezeDay(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required|exists:orders,id'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }
        $order_days = Order::whereId($request->order_id)->with('OrderMeals', function ($q) {
            $q->where('status', 'pending');
        })->first();

        $dates = [];
        foreach ($order_days->OrderMeals as $orderMeal) {
            if (!in_array($orderMeal->date, $dates)) {
                array_push($dates, $orderMeal->date);
            }

        }


        $old_dates = $dates;
        $today = Carbon::now()->format('Y-m-d');
        $tomorrow = Carbon::now()->addDay()->format('Y-m-d');


        if (($key = array_search($today, $old_dates)) !== false) {
            unset($old_dates[$key]);
        }
        if (($key = array_search($tomorrow, $old_dates)) !== false) {
            unset($old_dates[$key]);
        }


        $validator = Validator::make($request->all(), [
            'old_date' => 'required|in:' . implode(',', $old_dates), //after two days
            'new_date' => 'required|not_in:' . implode(',', $dates),
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }

        $orderMeals = OrderMeal::where('order_id', $request->order_id)
            ->where('date', $request->old_date)
            ->get();

        foreach ($orderMeals as $orderMeal) {
            $weekNumber = Carbon::parse($request->new_date)->weekNumberInMonth; //1   //2  //3   //4
            $is_odd = $weekNumber % 2;
            $is_odd == 0 ? $weekNumber = 2 : $weekNumber = 1;
            $package_type_prices = PackageMeal::where('package_id', $orderMeal->Order->package_id)
                ->where('meal_type_id', $orderMeal->meal_type_id)
                ->where('day', Carbon::parse($request->new_date)->format('l'))
                ->where('week', $weekNumber)
                ->with('Meal')
                ->first();

            $meal = Meal::find($package_type_prices->meal_id);
            $orderMeal->meal_id = $meal->id;
            $orderMeal->meal_title_ar = $meal->title_ar;
            $orderMeal->meal_title_en = $meal->title_en;
            $orderMeal->meal_body_ar = $meal->body_ar;
            $orderMeal->meal_body_en = $meal->body_en;
            $orderMeal->old_date = $request->old_date;
            $orderMeal->date = $request->new_date;
            $orderMeal->save();
        }
        return response()->json(msg($request, success(), trans('lang.freeze_success')));

    }


}
