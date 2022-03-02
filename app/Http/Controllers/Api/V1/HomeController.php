<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResources;
use App\Http\Resources\PackageResources;
use App\Http\Resources\ScreenResources;
use App\Http\Resources\SliderResources;
use App\Http\Resources\UsersResources;
use App\Models\Offer;
use App\Models\Package;
use App\Models\Screen;
use App\Models\Slider;
use App\Models\User;
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

        $data['on_zone'] = true;
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
