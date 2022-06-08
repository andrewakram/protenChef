<?php

namespace App\Http\Controllers\Api\V1\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\MealResources;
use App\Http\Resources\PackageMealResources;
use App\Http\Resources\PackageMealTypeAdditinalResources;
use App\Http\Resources\PackageMealTypeCustomResources;
use App\Http\Resources\PackageMealTypeMainResources;
use App\Http\Resources\PackageMealTypeResources;
use App\Http\Resources\PackageResources;
use App\Http\Resources\PackageTypePriceResources;
use App\Http\Resources\PackageTypeResource;
use App\Models\Meal;
use App\Models\MealType;
use App\Models\Package;
use App\Models\PackageMeal;
use App\Models\PackageMealType;
use App\Models\PackageType;
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

    public function package_parent_type(Request $request ,$package_id,$sub_package_type_id)
    {
//        $package_parent_type = PackageType::whereNull('parent_id')->with('SubPackages')->get();
//        $data = PackageTypeResource::collection($package_parent_type);
        $package_type_prices = PackageTypePrice::where('package_id', $package_id)
            ->where('package_type_id', $sub_package_type_id)
            ->get();
        $data['package_types_prices'] = (PackageTypePriceResources::collection($package_type_prices));


        return response()->json(msgdata($request, success(), trans('lang.success'), $data));


    }

    public function package_types(Request $request, $package_id)
    {
        $package = Package::find($package_id);
        if (!$package) {
            return response()->json(['status' => 401, 'msg' => trans('lang.you_should_choose_valid_package')]);
        }
        //object shape resources
        $data['package'] = (new PackageResources($package));

        $package_parent_type = PackageType::whereNull('parent_id')->get();
        $data = PackageTypeResource::collection($package_parent_type);
        //array shape resources


        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }

    public function package_meal_types(Request $request, $type, $package_pricec_id)
    {
        $package = PackageTypePrice::find($package_pricec_id);

        if (!$package) {
            return response()->json(['status' => 401, 'msg' => trans('lang.you_should_choose_valid_package_type')]);
        }
        $package_type_count = $package->PackageType->meal_count;
        if ($type == 'main') {
            $package_type_prices = PackageMealType::where('price', null)->where('package_type_price_id', $package_pricec_id)->limit($package_type_count)->get();

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
        $data['additional_meal_types'] = (PackageMealTypeAdditinalResources::collection($additional_meal_types));
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
        $lang = request()->header('lang');
        $two_dayes = Carbon::now()->addDay();
        $validator = Validator::make($request->all(), [
            'package_type_price_id' => 'required|exists:package_type_prices,id',
            'selected_date' => 'required|after:' . $two_dayes,
            'meal_type_id' => 'nullable|exists:meal_types,id',
            'meal_type' => 'nullable|in:main,sub',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }
        $exists_main_meals = PackageMealType::where('price', null)->where('package_type_price_id', $request->package_type_price_id)->orderBy('id', 'asc')->first();
        if (!$exists_main_meals) {
            return response()->json(msg($request, failed(), trans('lang.no_main_meals')));
        }
        //main meals
        //check if meal type sent  - if not sent it will select first meal type dynamically
        if (!$request->meal_type_id) {
            $first_main_meal_types = PackageMealType::query();
            if ($request->meal_type == 'sub') {
                $first_main_meal_types = $first_main_meal_types->where('price', '!=', null);
            } else {
                $first_main_meal_types = $first_main_meal_types->where('price', null);
            }
            $first_main_meal_types = $first_main_meal_types->where('package_type_price_id', $request->package_type_price_id)->orderBy('id', 'asc')->first();
            $meal_type_id = $first_main_meal_types->meal_type_id;
        } else {
            $meal_type_id = $request->meal_type_id;
        }

        $main_meal_types = PackageMealType::query();
        if ($request->meal_type == 'sub') {
            $main_meal_types = $main_meal_types->where('price', '!=', null);
        } else {
            $main_meal_types = $main_meal_types->where('price', null);
        }

        $packageTypePrice = PackageTypePrice::find($request->package_type_price_id);
        $meal_count = $packageTypePrice->PackageType->meal_count;


        $main_meal_types = $main_meal_types->where('package_type_price_id', $request->package_type_price_id)
            ->orderBy('id', 'asc')
            ->limit($meal_count)
            ->get();

        if (!$request->meal_type_id) {
            $data['main_meal_types'] = (PackageMealTypeCustomResources::collection($main_meal_types));
        } else {
//            $data['main_meal_types'] = PackageMealTypeCustomResources::customCollection($main_meal_types, $request->meal_type_id)->values();
            $data['main_meal_types'] = [];
        }
        //create selected period
        //generate finall day
        $package_type_price = PackageTypePrice::find($request->package_type_price_id);
        //check if backage have snaks or not ....
        $exists_snacks = PackageMealType::where('price', '!=', null)->where('package_type_price_id', $request->package_type_price_id)->first();
        if ($exists_snacks) {
            $package_type_price->have_snacks = true;
        } else {
            $package_type_price->have_snacks = false;
        }
        if (!$request->meal_type_id) {
            $data['package_price_Data'] = (new PackageTypePriceResources($package_type_price));
        } else {
            $data['package_price_Data'] = (object)[];
        }
        //$package_type_price->PackageType

        //convert selected date to carbon to generate period ...
        $selected_date_carbon = Carbon::parse($request->selected_date); // 13/4/2022
        //generate final date
        $final_date = $selected_date_carbon->addDays($package_type_price->PackageType->days_count);  // 13/4/2022 + 6  = result = 19/4/2022

        //generate period to make foreach
        $period = CarbonPeriod::create($request->selected_date, $final_date); // Period between 13/4 and 19/4  == 7 days {}
        // Iterate over the period
        if (count($period) > 0) {
            foreach ($period as $date) {
                $dates[] = $date->format('Y-m-d');
            }
            foreach ($dates as $date) {
                $weekNumber = Carbon::parse($date)->weekNumberInMonth; //1   //2  //3   //4
                $is_odd = $weekNumber % 2;
                $is_odd == 0 ? $weekNumber = 2 : $weekNumber = 1;
                if ($lang == 'ar') {
                    $selected_date = \Carbon\Carbon::parse($date);
                    $inserted_date = $selected_date->translatedFormat('l');
                } else {
                    $inserted_date = \Carbon\Carbon::parse($date)->format('Y-m-d');
                }
                $package_type_prices = PackageMeal::where('package_id', $package_type_price->package_id);
                //to avoid package usefully days
                if ($package_type_price->package_type_id == 4 || $package_type_price->package_type_id == 3) {
                    $package_type_prices = $package_type_prices->where('day', '!=', 'Friday')->where('day', '!=', 'Saturday');
                } elseif ($package_type_price->package_type_id == 2) {
                    $package_type_prices = $package_type_prices->where('day', '!=', 'Friday');
                }
                $package_type_prices = $package_type_prices->where('meal_type_id', $meal_type_id)
                    ->where('day', Carbon::parse($date)->format('l'))
                    ->where('week', $weekNumber)
                    ->with('Meal')
                    ->get()->map(function ($item) use ($date, $lang) {
                        if ($lang == 'ar') {
                            $selected_date = \Carbon\Carbon::parse($item->day);
                            $inserted_date = $selected_date->translatedFormat('l');
                            $item->day = $inserted_date;
                        }
                        $item->date = $date;
                        return $item;
                    });
                if (count($package_type_prices) > 0) {
                    foreach ($package_type_prices as $row) {
                        $output[] = $row;
                    }
                }
            }
            $data['meals'] = PackageMealResources::customCollection($output, $dates)->values();
            return response()->json(msgdata($request, success(), trans('lang.success'), $data));
        } else {
            return response()->json(msg($request, failed(), trans('lang.no_period_selected')));
        }
    }
}
