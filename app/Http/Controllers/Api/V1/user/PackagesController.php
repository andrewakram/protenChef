<?php

namespace App\Http\Controllers\Api\V1\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResources;
use App\Http\Resources\PackageMealResources;
use App\Http\Resources\PackageMealTypeResources;
use App\Http\Resources\PackageResources;
use App\Http\Resources\PackageTypePriceResources;
use App\Http\Resources\ScreenResources;
use App\Http\Resources\SliderResources;
use App\Http\Resources\UsersResources;
use App\Models\MealType;
use App\Models\Offer;
use App\Models\Package;
use App\Models\PackageMeal;
use App\Models\PackageMealType;
use App\Models\PackageType;
use App\Models\PackageTypePrice;
use App\Models\Screen;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
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

    public function package_menu_meals(Request $request, $package_id, $meal_type_id,$started_date)
    {
        $package = Package::find($package_id);
        if (!$package) {
            return response()->json(['status' => 401, 'msg' => trans('lang.you_should_choose_valid_package')]);
        }

        $MealType = MealType::find($meal_type_id);
        if (!$MealType) {
            return response()->json(['status' => 401, 'msg' => trans('lang.you_should_choose_valid_MealTypee')]);
        }

        $package_type_prices = PackageMeal::where('package_id', $package_id)->where('meal_type_id', $meal_type_id)->get();
        $data = (PackageMealResources::collection($package_type_prices));
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }


}
