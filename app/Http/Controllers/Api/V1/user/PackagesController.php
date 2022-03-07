<?php

namespace App\Http\Controllers\Api\V1\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\PackageMealResources;
use App\Http\Resources\PackageMealTypeResources;
use App\Http\Resources\PackageResources;
use App\Http\Resources\PackageTypePriceResources;
use App\Models\MealType;
use App\Models\Package;
use App\Models\PackageMeal;
use App\Models\PackageMealType;
use App\Models\PackageTypePrice;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Validator;
use JWTAuth;
use TymonJWTAuthExceptionsJWTException;

class PackagesController extends Controller
{

    public function package_types(Request $request, $package_id)
    {
        $package = Package::find($package_id);
        if (!$package) {
            return response()->json(['status' => 401, 'msg' => trans('lang.you_should_choose_valid_package')]);
        }
        //object shape resources
        $data['package'] = (new PackageResources($package));
        //array shape resources
        $package_type_prices = PackageTypePrice::where('package_id', $package_id)->get();
        $data['package_types_prices'] = (PackageTypePriceResources::collection($package_type_prices));

        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }

    public function package_meal_types(Request $request, $type, $package_pricec_id)
    {
        $package = PackageTypePrice::find($package_pricec_id);
        if (!$package) {
            return response()->json(['status' => 401, 'msg' => trans('lang.you_should_choose_valid_package_type')]);
        }
        if ($type == 'main') {
            $package_type_prices = PackageMealType::where('price', null)->where('package_type_price_id', $package_pricec_id)->get();
        } else {
            $package_type_prices = PackageMealType::where('price', '!=', null)->where('package_type_price_id', $package_pricec_id)->get();
        }
        $data = (PackageMealTypeResources::collection($package_type_prices));
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }

    public function package_menu_meals(Request $request)
    {
        $two_dayes = Carbon::now()->addDay(2);
        $validator = Validator::make($request->all(), [
            'meal_type_id' => 'required|exists:meal_types,id',
            'package_type_price_id' => 'required|exists:package_type_prices,id',
            'selected_date' => 'required|after:'.$two_dayes
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }

//create selected period
        //generate finall day
        $package_type_price = PackageTypePrice::findOrFail($request->package_type_price_id);
//        $package_type_price->PackageType
        $final_date = Carbon::now()->addDay(32);
        $period = CarbonPeriod::create($request->selected_date, $final_date);
        // Iterate over the period
        $week = 1;
        $day = 1;
        $period_details=[];
        foreach ($period as $dt) {
            array_push($period_details,$dt->format("Y-m-d"));
//            if (in_array($dt->format("l"), $days)) {
//                $course_data = new Episode_course_days;
//                $course_data->date = $dt->format("Y-m-d");
//                $course_data->episode_id = $episode->id;
//                $course_data->week_id = $week;
//                $course_data->day_id = $day;
//                //to generate starting date ...
//                $s_date = $dt->format("Y-m-d");
//                $s_Time = $episode->time_from;
//                $start = $s_date . ' ' . $s_Time;
//                $final_Start = date("Y-m-d H:i", strtotime($start));
//                $final_Start_carbon = Carbon::createFromFormat('Y-m-d H:i', $final_Start);
//                $course_data->started_at = $final_Start;
//                //add 10 minutes to start date to notify students
//                $notify_at = $final_Start_carbon->subMinute(10);
//                $course_data->notify_at = $notify_at;
//                $course_data->save();
//                if ($day == count($days)) {
//                    $day = 1;
//                    $week = $week + 1;
//                } else {
//                    $day = $day + 1;
//                }
//            }
        }
        $package_type_prices = PackageMeal::where('package_id', $package_type_price->package_id)->where('meal_type_id', $request->meal_type_id)->get();
        $data = PackageMealResources::customCollection($package_type_prices, $period_details)->response()->getData(true);
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }


}
