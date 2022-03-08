<?php

namespace App\Http\Controllers\Api\V1\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\MealResources;
use App\Http\Resources\PackageMealResources;
use App\Http\Resources\PackageMealTypeResources;
use App\Http\Resources\PackageResources;
use App\Http\Resources\PackageTypePriceResources;
use App\Models\Meal;
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

    public function package_price_details(Request $request, $package_pricec_id)
    {
        $package = PackageTypePrice::find($package_pricec_id);
        if (!$package) {
            return response()->json(['status' => 401, 'msg' => trans('lang.you_should_choose_valid_package_type')]);
        }
        $main_meal_types = PackageMealType::where('price', null)->where('package_type_price_id', $package_pricec_id)->get();
        $additional_meal_types = PackageMealType::where('price', '!=', null)->where('package_type_price_id', $package_pricec_id)->get();

        $data['package_price_Data'] = (new PackageTypePriceResources($package));
        $data['main_meal_types'] = (PackageMealTypeResources::collection($main_meal_types));
        $data['additional_meal_types'] = (PackageMealTypeResources::collection($additional_meal_types));
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }

    public function meal_details(Request $request, $id)
    {
        $meal = Meal::find($id);
        if (!$meal) {
            return response()->json(['status' => 401, 'msg' => trans('lang.you_should_choose_valid_meal')]);
        }

        $data = (new MealResources($meal));
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }

    public function package_menu_meals(Request $request)
    {
        $two_dayes = Carbon::now()->addDay(2);
        $validator = Validator::make($request->all(), [
            'meal_type_id' => 'required|exists:meal_types,id',
            'package_type_price_id' => 'required|exists:package_type_prices,id',
            'selected_date' => 'required|after:' . $two_dayes
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }

//create selected period
        //generate finall day
        $package_type_price = PackageTypePrice::findOrFail($request->package_type_price_id);
//        $package_type_price->PackageType
        $final_date = $two_dayes->addDays(28);
        $period = CarbonPeriod::create($request->selected_date, $final_date);
        // Iterate over the period

        foreach ($period as $date) {
            $dates[] = $date->format('Y-m-d');
        }

        foreach ($dates as $date) {
            $weekNumber = Carbon::parse($date)->weekNumberInMonth; //1   //2  //3   //4
            $is_odd = $weekNumber % 2;
            $is_odd == 0 ? $weekNumber = 2 : $weekNumber = 1;
            $package_type_prices = PackageMeal::where('package_id', $package_type_price->package_id)
                ->where('meal_type_id', $request->meal_type_id)
                ->where('day', Carbon::parse($date)->format('l'))
                ->where('week', $weekNumber)
                ->with('Meal')
                ->get()->map(function ($item) use ($date) {
                    $item->date = $date;
                    return $item;
                });
            foreach ($package_type_prices as $row) {

                $output[] = $row;

            }
        }

        $data = PackageMealResources::customCollection($output,$dates)->collection->groupBy('date');
        return response()->json(msgdata($request, success(), trans('lang.success'), $data->values()));
    }


}
