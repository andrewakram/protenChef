<?php

namespace App\Http\Controllers\Api\V1\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResources;
use App\Http\Resources\PackageResources;
use App\Http\Resources\ScreenResources;
use App\Http\Resources\SliderResources;
use App\Http\Resources\UsersResources;
use App\Models\BusinessSetting;
use App\Models\Offer;
use App\Models\Package;
use App\Models\Screen;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\User;
use App\Models\Zone;
use Grimzy\LaravelMysqlSpatial\Types\Point;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use JWTAuth;
use TymonJWTAuthExceptionsJWTException;

class HomeController extends Controller
{

    public function home(Request $request)
    {
        $sliders = Slider::active()->get();
        $packages = Package::active()->get();
        $offers = Offer::active()->get();


        //check my location in zone

        $point = new Point($request->lat, $request->lng);
        $zone = Zone::contains('coordinates', $point)->first();
        if (!$zone) {
            $data['on_zone'] = false;
        } else {
            $data['on_zone'] = true;
        }
        $data['sliders'] = (SliderResources::collection($sliders));
        $data['packages'] = (PackageResources::collection($packages));
        $data['offers'] = (OfferResources::collection($offers));
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }

    public function screens(Request $request)
    {
        $screens = Screen::get();
        $screens = (ScreenResources::collection($screens));
        return response()->json(msgdata($request, success(), trans('lang.success'), $screens));
    }
}
