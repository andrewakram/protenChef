<?php

namespace App\Http\Controllers\Api\V1\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResources;
use App\Http\Resources\OfferResources;
use App\Http\Resources\PackageResources;
use App\Http\Resources\PackageTypePriceResources;
use App\Http\Resources\ScreenResources;
use App\Http\Resources\SliderResources;
use App\Http\Resources\UsersResources;
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

class LocationsController extends Controller
{

    public function locations(Request $request)
    {
        $user_id = auth()->user()->id;
        $locations = Location::where('user_id', $user_id)->get();
        $data = (LocationResources::collection($locations));
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }

    public function create(Request $request)
    {
        $user_id = auth()->user()->id;
        $data = $request->all();
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'bulding_num' => 'required|string|max:255',
            'flat_num' => 'required|string|max:255',
            'body' => 'required|string|max:255',
            'lat' => 'required|string|max:255',
            'lng' => 'required|string|max:255',
            'notes' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }
        $exists_main = Location::where('user_id', $user_id)->where('type', 'main')->first();
        if ($exists_main) {
            $data['type'] = 'sub';
        } else {
            $data['type'] = 'main';
        }
        $data['user_id'] = $user_id;
        $location = Location::create($data);

        return response()->json(msgdata($request, success(), trans('lang.success'), $location));
    }

    public function make_main(Request $request, $id)
    {
        $user_id = auth()->user()->id;
        $location = Location::where('user_id', $user_id)->whereId($id)->first();
        if ($location) {
            Location::where('user_id', $user_id)->update(['type'=>'sub']);
            $location->type = 'main';
            $location->save();
            return response()->json(msg($request, success(), trans('lang.success')));

        } else {
            return response()->json(['status' => 401, 'msg' => trans('lang.you_should_choose_valid_location')]);
        }
    }

    public function delete(Request $request, $id)
    {
        $user_id = auth()->user()->id;
        $locations = Location::where('user_id', $user_id)->whereId($id)->first();
        if ($locations) {
            $locations->delete();
        } else {
            return response()->json(['status' => 401, 'msg' => trans('lang.you_should_choose_valid_location')]);

        }
        return response()->json(msg($request, success(), trans('lang.success')));
    }

}
