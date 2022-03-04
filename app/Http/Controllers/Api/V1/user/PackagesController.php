<?php

namespace App\Http\Controllers\Api\V1\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResources;
use App\Http\Resources\PackageResources;
use App\Http\Resources\PackageTypePriceResources;
use App\Http\Resources\ScreenResources;
use App\Http\Resources\SliderResources;
use App\Http\Resources\UsersResources;
use App\Models\Offer;
use App\Models\Package;
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
        if(!$package){
            return response()->json(['status' => 401, 'msg' => 'you_should_choose_valid_package']);

        }
        $package_type_prices = PackageTypePrice::where('package_id', $package_id)->get();
        $data['package'] = (new PackageResources($package));
        $data['package_types_prices'] = (PackageTypePriceResources::collection($package_type_prices));
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }


}
