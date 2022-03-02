<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UsersResources;
use App\Models\User;
use App\Models\Verfication;
use Carbon\Carbon;
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
            if ($user->active == 0) {
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
            'device_token' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        $data = new User();
        $data->name = $request->phone;
        $data->phone = $request->phone;
        $data->password = $request->password;
        $data->save();

        $this->sendCode($data->phone, "activate");

        return response()->json(msg($request, success(), trans('lang.CodeSent')));

    }

    public function Verify(Request $request)
    {
        $validator = Validator::make($request->all(), [
//            'phone' => 'required|min:12|regex:/(966)[0-9]{8}/',
            'phone' => 'required|exists:users,phone',
            'code' => 'required|min:4',
        ]);
        if ($validator->fails()) {
            return response()->json(['status' => 401, 'msg' => $validator->messages()->first(), 'data' => (object)[]]);
        }

        $user = User::where('phone', $request->phone)->first();
        if ($user->active == 0) {
            $type = "activate";
        } else {
            $type = "reset";
        }

        $verfication = Verfication::where('phone', $request->phone)
            ->where('code', $request->code)
            ->where('type', $type)
            ->where('expired_at', '>', Carbon::now()->toDateTimeString())
            ->first();
        if ($verfication) {
            if ($type == "activate") {
                $user->active = 1;
                $user->save();

                $jwt_token = JWTAuth::fromUser($user);
                $data = (new UsersResources($user))->token($jwt_token);
                return response()->json(msgdata($request, success(), trans('lang.success'), $data));
            } else {

                $jwt_token = JWTAuth::fromUser($user);
                $data = (new UsersResources($user))->token($jwt_token);
                return response()->json(msgdata($request, success(), trans('lang.success'), $data));
            }
        } else {
            $this->sendCode($request->phone, $type);
            return response()->json(msg($request, failed(), trans('lang.codeErrorSentAgain')));
        }


    }

    public
    function sendCode($phone, $type)
    {

        $code = rand(0000, 9999);
        $code = 1111;

        Verfication::updateOrcreate
        (
            [
                'phone' => $phone,
            ],
            [
                'code' => $code,
                'type' => $type,
                'expired_at' => Carbon::now()->addHour()->toDateTimeString()
            ]
        );

        return response()->json(msg("request", success(), trans('lang.CodeSent')));
    }
}
