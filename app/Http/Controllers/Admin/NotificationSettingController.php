<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\NotificationSettingRequest;
use App\Http\Requests\SettingRequest;
use App\Models\NotificationSetting;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NotificationSettingController extends Controller
{
    public function index()
    {
        $data = NotificationSetting::get();
        return view('admin.pages.notification_settings.settings', compact('data'));
    }

    public function update(NotificationSettingRequest $request)
    {
        $langs=["ar","en"];
        $types = ['other','Order','Meal','Offer','Coupon'];
        foreach ($langs as $lang){
            foreach ($types as $type){
                NotificationSetting::where('lang',"$lang")->where('type',"$type")->update([
                    'title' => $request->title["$lang"]["$type"],
                    'body' => $request->body["$lang"]["$type"],
                ]);
            }
        }
        session()->flash('success', 'تم التعديل بنجاح');
        return back();
    }


}
