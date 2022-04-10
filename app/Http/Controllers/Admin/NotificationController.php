<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notification;
use App\Models\Offer;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NotificationController extends Controller
{
    public function index()
    {
        return view('admin.pages.notifications.index');
    }

    public function create()
    {
        $users = User::orderBy('id','desc')->select('id','name','phone')->get();
        $offers = Offer::orderBy('id','desc')->select('id','title_ar','created_at')->get();
        return view('admin.pages.notifications.create',compact('users','offers'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar' => 'required',
            'body_ar' => 'required',
            'title_en' => 'required',
            'body_en' => 'required',
            'model_type' => 'required|in:other,Coupon,Order,Meal,Offer',
            'user_id' => 'sometimes',
            'model_id' => 'sometimes',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if($request->model_type == 'Order'){
            $data = Notification::create([
                'title_ar' => $request->title_ar,
                'body_ar' => $request->body_ar,
                'title_en' => $request->title_en,
                'body_en' => $request->body_en,
                'model_type' => $request->model_type,
                'model_id' => isset($request->order_id) ? $request->order_id : NULL,
                'user_id' => $request->user_id[0],
            ]);
            $user_token = User::whereId($request->user_id[0])->select('fcm_token')->first()->fcm_token;
            Notification::send($user_token, $request->title, $request->body, $request->model_type,$data);
        }else{
            ///>>>>>>>> start sending
            $user_tokens = [];
            if(isset($request->user_id) && sizeof($request->user_id) > 0){
                foreach ($request->user_id as $user_id){
                    $data = Notification::create([
                        'title_ar' => $request->title_ar,
                        'body_ar' => $request->body_ar,
                        'title_en' => $request->title_en,
                        'body_en' => $request->body_en,
                        'model_type' => $request->model_type,
                        'model_id' => isset($request->offer_id) ? $request->offer_id : NULL,
                        'user_id' => $user_id,
                    ]);
                    $user_token = User::whereId($request->user_id[0])->select('fcm_token')->first()->fcm_token;
                    if(!empty($user_token) && $user_token !=Null){
                        array_push($user_tokens,$user_token);
                    }
                }
            }else{
                $users = User::whereSuspend(0)->whereActive(1)->whereNotNull('fcm_token')
                    ->select('id','fcm_token')->get();
                foreach ($users as $user){
                    Notification::create([
                        'title_ar' => $request->title_ar,
                        'body_ar' => $request->body_ar,
                        'title_en' => $request->title_en,
                        'body_en' => $request->body_en,
                        'model_type' => $request->model_type,
                        'model_id' => isset($request->model_id) ? $request->model_id : NULL,
                        'user_id' => $user->id,
                    ]);
                    if(!empty($user_token) && $user_token !=Null){
                        array_push($user_tokens,$user->fcm_token);
                    }
                }
            }
            Notification::send($user_tokens, $request->title, $request->body, $request->model_type,$data);
            ///>>>>>>>> end sending
        }

        session()->flash('success', 'تم الإضافة بنجاح');
        return redirect()->route('admin.notifications');
    }

    public function edit($id)
    {
        $users = User::orderBy('id','desc')->select('id','name','phone')->get();
        $coupon_users_array = NotificationUser::where('coupon_id',$id)->pluck('user_id')->toArray();
        $row = Notification::where('id',$id)->first();
        if (!$row){
            session()->flash('error', 'الحقل غير موجود');
            return redirect()->back();
        }
        return view('admin.pages.notifications.edit',compact('row','users','coupon_users_array'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:coupons,id',
            'code' => 'required',
            'type' => 'required|in:fixed,percent',
            'amount' => 'required|numeric|min:1',
            'min_order_total' => 'required|numeric|min:1',
            'expired_at' => 'required',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

//        if ($request->has('image') && is_file($request->image)){
//            if (!empty($city->getOriginal('image'))){
//                unlinkFile($city->getOriginal('image'), 'cities');
//            }
//        }
        $row = Notification::whereId($request->row_id)->first();
        $row->update($request->except('row_id','_token'));
        $row->save();

        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->route('admin.notifications');
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:coupons,id',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['message' => 'Failed']);
        }

        $row = Notification::where('id',$request->row_id)->first();
//        if (!empty($city->getOriginal('image'))){
//            unlinkFile($city->getOriginal('image'), 'cities');
//        }
        $row->delete();
        session()->flash('success', 'تم الحذف بنجاح');
        return response()->json(['message' => 'Success']);
    }
    public function deleteMulti(Request $request)
    {
        $ids_array = explode(',', $request->ids);
        foreach ($ids_array as $id) {
            $delete =$this->destroy($id);
            if (!$delete){
                session()->flash('success', 'حدث خطأ ما');
                return redirect()->back();
            }
        }
        session()->flash('success', 'تم الحذف بنجاح');
        return redirect()->back();
    }
    public function destroy($id)
    {
        $row = Notification::where('id',$id)->first();
//        if (!empty($city->getOriginal('image'))){
//            unlinkFile($city->getOriginal('image'), 'cities');
//        }
        return $row->delete();
    }

    public function getData()
    {
        $auth = Auth::guard('admin')->user();
        $model = Notification::query()->orderBy('created_at','desc');
        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('type',function ($row){
//                ('other', 'Coupon', 'Order', 'Meal', 'Offer')
                if ($row->model_type == "other"){
                    return "<b class='badge badge-dark'>بدون</b>";
                }elseif($row->model_type == "Coupon"){
                    return "<b class='badge badge-success'>كوبون</b>";
                }elseif($row->model_type == "Order"){
                    return "<b class='badge badge-warning'>طلب</b>";
                }elseif($row->model_type == "Meal"){
                    return "<b class='badge badge-info'>وجبة</b>";
                }elseif($row->model_type == "Offer"){
                    return "<b class='badge badge-primary'>عرض</b>";
                }
            })
            ->editColumn('created_at',function ($row){
                return Carbon::parse($row->created_at)->format("Y-m-d (H:i) A");
            })

            ->addColumn('user',function ($row){
                if(isset($row->user_id)){
                    $user_name = $row->User->name;
                    return '<a href="'.route('admin.users.edit',[$row->user_id]).'" target="_blank" class="" title="العميل">
                            '.$user_name.'
                        </a>';
                }else{
                    return '-';
                }

            })
            ->addColumn('actions', function ($row) use ($auth){
                $buttons = '';
                if($row->model_type == "Order"){
                    $buttons .= '<a href="'.route('admin.orders.edit',[$row->model_id]).'" class="btn btn-warning btn-circle btn-sm m-1" title=" تفاصيل الطلب" target="_blank">
                                    <i class="fa fa-cart-plus"></i>
                                </a>';
                }elseif($row->model_type == "Offer"){
                    $buttons .= '<a href="'.route('admin.offers.edit',[$row->model_id]).'" class="btn btn-primary btn-circle btn-sm m-1" title=" تفاصيل العرض" target="_blank">
                                    <i class="fa fa-gift"></i>
                                </a>';
                }
//                if ($auth->can('sliders.update')) {
//                    $buttons .= '<a href="'.route('admin.notifications.edit',[$row->id]).'" class="btn btn-primary btn-circle btn-sm m-1" title="تعديل">
//                            <i class="fa fa-edit"></i>
//                        </a>';
//                }
//                if ($auth->can('sliders.delete')) {
                    $buttons .= '<a class="btn btn-danger btn-sm delete btn-circle m-1" data-id="'.$row->id.'"  title="حذف">
                            <i class="fa fa-trash"></i>
                        </a>';

                    //

//                }
                return $buttons;
            })
            ->rawColumns(['actions','type','user','created_at'])
            ->make();

    }


    public function getNotificationData(Request $request)
    {
        if(isset($request->notification_type_id) && isset($request->users_id)){
            if($request->notification_type_id == "Order"){
                $orders = Order::orderBy('id','desc')->where('user_id',$request->users_id[0])
                    ->select('id','order_num','created_at')->get();
                return response()->json($orders);
            }
        }
        return response()->json([]);
    }
}
