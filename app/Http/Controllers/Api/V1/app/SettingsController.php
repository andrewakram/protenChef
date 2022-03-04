<?php

namespace App\Http\Controllers\Api\V1\app;

use App\Http\Controllers\Controller;
use App\Http\Resources\OfferResources;
use App\Http\Resources\PackageResources;
use App\Http\Resources\PagesResources;
use App\Http\Resources\ScreenResources;
use App\Http\Resources\SliderResources;
use App\Http\Resources\UsersResources;
use App\Models\BusinessSetting;
use App\Models\Offer;
use App\Models\Package;
use App\Models\Page;
use App\Models\Screen;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use JWTAuth;
use TymonJWTAuthExceptionsJWTException;

class SettingsController extends Controller
{
    public function settings(Request $request)
    {
        $settings = Setting::get();
//        $screens = (ScreenResources::collection($screens));
        return response()->json(msgdata($request, success(), trans('lang.success'), $settings));
    }
    public function pages(Request $request,$type)
    {
        $page = Page::where('type',$type)->first();
        if(!$page){
            return response()->json(['status' => 401, 'msg' => trans('lang.page_not_found')]);
        }
        $data = (new PagesResources($page));
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }
}
