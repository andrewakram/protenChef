<?php

namespace App\Http\Controllers\Api\V1\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\CouponResources;
use App\Http\Resources\LocationResources;
use App\Http\Resources\OfferResources;
use App\Http\Resources\PackageResources;
use App\Http\Resources\PackageTypePriceResources;
use App\Http\Resources\ScreenResources;
use App\Http\Resources\SliderResources;
use App\Http\Resources\UsersResources;
use App\Models\CouponUser;
use App\Models\Location;
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

class CouponsController extends Controller
{

    public function coupons(Request $request)
    {
        $user_id = auth()->user()->id;
        $locations = CouponUser::where('user_id', $user_id)->where('used',0)->get();
        $data = (CouponResources::collection($locations));
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }

}
