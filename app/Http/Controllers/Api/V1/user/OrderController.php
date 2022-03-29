<?php

namespace App\Http\Controllers\Api\V1\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\MealResources;
use App\Http\Resources\PackageMealResources;
use App\Http\Resources\PackageMealTypeResources;
use App\Http\Resources\PackageResources;
use App\Http\Resources\PackageTypePriceResources;
use App\Models\Coupon;
use App\Models\CouponUser;
use App\Models\Location;
use App\Models\Meal;
use App\Models\MealType;
use App\Models\Order;
use App\Models\OrderAddition;
use App\Models\OrderMeal;
use App\Models\Package;
use App\Models\PackageMeal;
use App\Models\PackageMealType;
use App\Models\PackageTypePrice;
use App\Models\Setting;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use TymonJWTAuthExceptionsJWTException;

class OrderController extends Controller
{

    public function make_order(Request $request)
    {
        $two_dayes = Carbon::now()->addDay(1);
        $validator = Validator::make($request->all(), [
            'selected_date' => 'required|after:' . $two_dayes,
            'package_type_id' => 'required|exists:package_type_prices,id',
            'location_id' => 'nullable|exists:locations,id',
            'selected_meal' => 'required|array',
            'order_additions' => 'nullable|array',
            'coupon_code' => 'nullable|exists:coupons,code',
            'discount_price' => 'nullable|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }

        $user_id = auth()->user()->id;
        $order_data['user_id'] = $user_id;

        $packageTypePrice = PackageTypePrice::find($request->package_type_id);
        $price = $packageTypePrice->price;

        $order_data['package_id'] = $packageTypePrice->package_id;
        $order_data['package_name_ar'] = $packageTypePrice->Package->title_ar;
        $order_data['package_name_en'] = $packageTypePrice->Package->title_en;

        $order_data['package_type_id'] = $request->package_type_id;
        $order_data['package_type_ar'] = $packageTypePrice->PackageType->title_ar;
        $order_data['package_type_en'] = $packageTypePrice->PackageType->title_en;
        $order_data['package_price'] = $price;


        $order_data['start_date'] = $request->selected_date;
        //delivery cost
        if ($request->location_id) {
            $delivery_cost = Setting::where('key', 'shipp_value')->first()->value;
            if ($delivery_cost) {
                $order_data['shipping_price'] = $delivery_cost;
            }
        } else {
            $delivery_cost = 0;
        }


        //generate location
        if ($request->location_id) {
            $location = Location::find($request->location_id);
            $order_data['lat'] = $location->lat;
            $order_data['lng'] = $location->lng;
            $order_data['location_body'] = $location->body;
        }
        //end generate location

        //coupon check if exists
        if ($request->coupon_code) {
            $coupon = Coupon::where('code', $request->coupon_code)->first();
            $exists_coupon = CouponUser::where('user_id', $user_id)->where('coupon_id', $coupon->id)->first();
            if ($exists_coupon) {
                return response()->json(msg($request, failed(), trans('lang.coupon_used_before')));
            }
        }
        //end coupon check
        // generate order number
        $now = Carbon::now()->year;
        $exist_order = Order::first();
        if ($exist_order == null) {
            $order_number = $now . '0001';
        } else {
            $last_order = Order::get()->max('order_num');
            $order_number = $last_order + 1;
        }
        $order_data['order_num'] = $order_number;
        //end generate order number

        //generate additional price
        $additional_price = 0;
        if ($request->order_additions) {
            foreach ($request->order_additions as $row) {
                $additional_price = $additional_price + $row['price'];
            }
        }
        //End additional price
        //Begin Discount
        if (!$request->discount_price) {
            $request->discount_price = 0;
        }
        $order_data['discount_price'] = $request->discount_price;
        //End Discount

        //Begin generate total bill
        $total = $price + $additional_price + $delivery_cost - $request->discount_price;
        $order_data['total_price'] = $total;
        //End generate total bill

        $order = Order::create($order_data);
        //add meals to order
        if ($request->selected_meal) {
            foreach ($request->selected_meal as $row) {
                $package_meal = PackageMeal::findOrFail($row['meal_id']);
                $order_meal_data['order_id'] = $order->id;
                $order_meal_data['meal_id'] = $row['meal_id'];
                $order_meal_data['meal_title_ar'] = $package_meal->Meal->title_ar;
                $order_meal_data['meal_title_en'] = $package_meal->Meal->title_en;
                $order_meal_data['meal_body_ar'] = $package_meal->Meal->body_ar;
                $order_meal_data['meal_body_en'] = $package_meal->Meal->body_en;
                $order_meal_data['date'] = $row['date'];
                $order_meal_data['meal_type_id'] = $row['meal_type_id '];
                OrderMeal::create($order_meal_data);
            }
        }
        if ($request->order_additions) {
            foreach ($request->order_additions as $row) {
                $order_addition_data['price'] = $row['price'];
                $order_addition_data['order_id'] = $order->id;
                $order_addition_data['meal_type_id'] = $row['meal_type_id'];
                OrderAddition::create($order_addition_data);
            }
        }
        //add user to coupon usage to avoid user to use this coupon again
        if ($request->coupon_code) {
            $coupon = Coupon::where('code', $request->coupon_code)->first();
            $user_coupon_data['user_id'] = $user_id;
            $user_coupon_data['coupon_id'] = $coupon->id;
            $user_coupon_data['used'] = 1;
            CouponUser::create($user_coupon_data);
        }
        //end coupon usage to avoid user to use this coupon again

        return response()->json(msgdata($request, success(), trans('lang.success'), $order));
    }

    public function apply_coupon(Request $request)
    {
        $user_id = auth()->user()->id;
        $validator = Validator::make($request->all(), [
            'coupon_code' => 'required|exists:coupons,code',
            'price' => 'required|numeric',
        ]);
        if ($validator->fails()) {
            return response()->json(msg($request, failed(), $validator->messages()->first()));
        }
        $exists_coupon = Coupon::where('code', $request->coupon_code)->first();

        if ($exists_coupon) {
            $code_used = CouponUser::where('user_id', $user_id)->where('coupon_id', $exists_coupon->id)->first();
            if ($code_used) {
                return response()->json(msg($request, failed(), trans('lang.coupon_used_before')));
            }
            $data['done'] = true;
            $price = $request->price;
            if ($exists_coupon->type == 'percent') {
                $discount_persentage = $exists_coupon->amount / 100;
                $discount = $discount_persentage * $price;
                $finat_price = $price - $discount;
                $data['type'] =$exists_coupon->type ;
                $data['old_price'] = $price;
                $data['discount'] = $discount;
                $data['new_price'] = $finat_price;
            } else {
                if ($price >= $exists_coupon->min_order_total) {
                    $finat_price = $price - $exists_coupon->amount;
                    $data['type'] =$exists_coupon->type ;
                    $data['old_price'] = $price;
                    $data['discount'] = $exists_coupon->amount;
                    $data['new_price'] = ($finat_price < 0) ? 0 : $finat_price;
                } else {
                    return response()->json(msg($request, failed(), trans('lang.should_have_min_order_cost')));
                }
            }
            return response()->json(msgdata($request, success(), trans('lang.coupon_send_s'), $data));
        } else {
            return response()->json(msg($request, failed(), trans('lang.you_should_choose_valid_coupon')));
        }
    }


}
