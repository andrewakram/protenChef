<?php

namespace App\Http\Controllers\Api\V1\user;

use App\Http\Controllers\Controller;
use App\Http\Resources\MealTypeResources;
use App\Http\Resources\NotificationResources;
use App\Http\Resources\OrderAdditionResources;
use App\Http\Resources\OrderMealsResources;
use App\Http\Resources\OrdersResources;
use App\Models\BankData;
use App\Models\Meal;
use App\Models\MealType;
use App\Models\Notification;
use App\Models\Order;
use App\Models\OrderAddition;
use App\Models\OrderMeal;
use App\Models\PackageMeal;
use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Validator;

class NotificationsController extends Controller
{
    public function notifications(Request $request,$pagination)
    {
        $user = auth()->user();
        $orders = Notification::where('user_id', $user->id)->orderBy('created_at','desc')->paginate($pagination);
        $data = NotificationResources::collection($orders)->response()->getData(true);
        return response()->json(msgdata($request, success(), trans('lang.success'), $data));
    }

}
