<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResources;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
use JWTAuth;
use TymonJWTAuthExceptionsJWTException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'phone' => 'required',
//           'phone' => 'required|min:12|regex:/(966)[0-9]{8}/',
            'password' => 'required|min:6',
            'device_token' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first()]);
        }
        $input = $request->only('phone', 'password');
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json(msg($request, not_authoize(), trans('lang.phoneOrPasswordIncorrect')));
        } else {
            $user = Auth::user();
            if ($user->active == 0){
                return response()->json(msg($request, not_active(), trans('lang.not_active')));

            }
            $user->fcm_token = $request->device_token;
            $user->save();

            $data = (new UsersResources($user))->token($jwt_token);
            return response()->json(msgdata($request, success(), trans('lang.success'), $data));
        }

    }

    public function SignUp(Request $request)
    {
        $validator = Validator::make($request->all(), [
//            'phone' => 'required|min:12|regex:/(966)[0-9]{8}/',
            'phone' => 'required|unique:users',
            'password' => 'required|min:6|confirmed',


        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        $data = new User();
        $data->name = $request->phone;
        $data->phone = $request->phone;
        $data->password = $request->password;
        $data->save();

        $ver

        $input = $request->only('phone', 'password');
        if (!$jwt_token = JWTAuth::attempt($input)) {
            return response()->json(msg($request, not_authoize(), trans('lang.phoneOrPasswordIncorrect')));
        } else {
            $user = Auth::user();
            $user->fcm_token = $request->device_token;
            $user->save();

            $data = (new UsersResources($user))->token($jwt_token);
            return response()->json(msgdata($request, success(), trans('lang.success'), $data));
        }

    }
}
