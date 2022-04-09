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
        $types = ['other','Meal','Offer','Coupon'];
        foreach ($types as $type){
            NotificationSetting::where('type',"$type")->update([
                'title_ar' => $request->title_ar["$type"][0],
                'title_en' => $request->title_en["$type"][0],
                'body_ar' => $request->body_ar["$type"][0],
                'body_en' => $request->body_en["$type"][0],
            ]);
        }
        $statuses=[0,1,2,3,4];
        foreach ($statuses as $status){
            NotificationSetting::where('type',"Order")->where('status',"$status")->update([
                'title_ar' => $request->title_ar["$type"]["$status"],
                'title_en' => $request->title_en["$type"]["$status"],
                'body_ar' => $request->body_ar["$type"]["$status"],
                'body_en' => $request->body_en["$type"]["$status"],
            ]);
        }
        session()->flash('success', 'تم التعديل بنجاح');
        return back();
    }


}
