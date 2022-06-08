<?php

namespace App\Http\Controllers\Admin;

use App\Models\Meal;
use App\Models\MealType;
use App\Models\Notification;
use App\Models\NotificationSetting;
use App\Models\Order;
use App\Models\OrderMeal;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index($status)
    {
        return view('admin.pages.orders.index',compact('status'));
    }

    public function create()
    {
        return view('admin.pages.orders.create',compact('status'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar' => 'required',
            'title_en' => 'required',
            'type' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $row = new Order();
        $row->image = $request->image;
        $row->title_ar = $request->title_ar;
        $row->title_en = $request->title_en;
        $row->type = $request->type;
        $row->save();
            session()->flash('success', 'تم الإضافة بنجاح');
        return redirect()->route('admin.orders',[$request->status]);
    }

    public function edit($id)
    {
        $meal_types = MealType::select('id','title_ar')->get();
        if(sizeof($meal_types) > 0){
            $meals = Meal::where('meal_type_id',$meal_types[0]->id)->select('id','title_ar')->get();
        }else{
            $meals = [];
        }

        $row = Order::findOrFail($id);
        $status = $row->status;
        if (!$row){
            session()->flash('error', 'الحقل غير موجود');
            return redirect()->back();
        }
        return view('admin.pages.orders.edit',
            compact('row','status','meal_types','meals'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:orders,id',
            'status' => 'required|in:pending,accepted,canceled,finished',
            'cancel_price' => 'sometimes',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

//        if ($request->has('image') && is_file($request->image)){
//            if (!empty($city->getOriginal('image'))){
//                unlinkFile($city->getOriginal('image'), 'cities');
//            }
//        }
        $row = Order::whereId($request->row_id)->first();
        $row->update([
            'start_date' => isset($request->start_date) ? $request->start_date : $row->start_date,
            'cancel_date' => isset($request->cancel_price) ? Carbon::now() : NULL,
            'cancel_price' => isset($request->cancel_price) ? $request->cancel_price : NULL,
            'status' => $request->status,
        ]);
        $row->save();
        $user_token = User::whereId($row->user_id)->select('fcm_token')->first()->fcm_token;
        if($row->status != $request->status){
            if(!empty($user_token) && $user_token !=Null) {
                $data['model_id'] = $request->row_id;
                $data['model_type'] = "Order";
                $NotificationSetting = NotificationSetting::where('status',2)->where('type',"Order")->first();
                $data = Notification::create([
                    'title_ar' => "طلب رقم:" .$row->Order->order_num. " -". $NotificationSetting->title_ar,
                    'body_ar' => "طلب رقم:" .$row->Order->order_num. " -".$NotificationSetting->body_ar,
                    'title_en' => "Order #".$row->Order->order_num. " -".$NotificationSetting->title_en,
                    'body_en' => "Order #".$row->Order->order_num. " -".$NotificationSetting->body_en,
                    'model_type' => "Order",
                    'model_id' => isset($row->order_id) ? $row->order_id : NULL,
                    'user_id' => $row->Order->user_id,
                ]);
                Notification::send($user_token, $NotificationSetting->title_ar, $NotificationSetting->body_ar, $data['model_type'], $data);
            }
        }
        if(isset($request->cancel_price) && $row->cancel_price != $request->cancel_price){
            if(!empty($user_token) && $user_token !=Null) {
                $data['model_id'] = $request->row_id;
                $data['model_type'] = "Order";
                $NotificationSetting = NotificationSetting::where('status',4)->where('type',"Order")->first();
                $data = Notification::create([
                    'title_ar' => "طلب رقم:" .$row->Order->order_num. " -". $NotificationSetting->title_ar,
                    'body_ar' => "طلب رقم:" .$row->Order->order_num. " -".$NotificationSetting->body_ar,
                    'title_en' => "Order #".$row->Order->order_num. " -".$NotificationSetting->title_en,
                    'body_en' => "Order #".$row->Order->order_num. " -".$NotificationSetting->body_en,
                    'model_type' => "Order",
                    'model_id' => isset($row->order_id) ? $row->order_id : NULL,
                    'user_id' => $row->Order->user_id,
                ]);
                Notification::send($user_token, $NotificationSetting->title_ar, $NotificationSetting->body_ar, $data['model_type'], $data);
            }
        }

        session()->flash('success', 'تم التعديل بنجاح');
        return back();
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:meal_types,id',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['message' => 'Failed']);
        }

        $row = Order::where('id',$request->row_id)->first();
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
        $row = Order::where('id',$id)->first();
//        if (!empty($city->getOriginal('image'))){
//            unlinkFile($city->getOriginal('image'), 'cities');
//        }
        return $row->delete();
    }

    public function changeOrderMealStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:order_meals,id',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            session()->flash('success', 'حدث خطأ ما');
            return redirect()->back();
        }
        $row = OrderMeal::where('id',$request->row_id)->first();
        $basic_order_data = $row->status;
        $row->status = $request->status;
        $row->save();
        $user_token = User::whereId($row->Order->user_id)->first();
        if($request->status != $basic_order_data ){
            if($user_token->fcm_token != Null) {
                $data['model_id'] = $request->row_id;
                $data['model_type'] = "Order";
                $NotificationSetting = NotificationSetting::where('status',3)->where('type',"Order")->first();
                $data = Notification::create([
                    'title_ar' => "طلب رقم:" .$row->Order->order_num. " -". $NotificationSetting->title_ar,
                    'body_ar' => "طلب رقم:" .$row->Order->order_num. " -".$NotificationSetting->body_ar,
                    'title_en' => "Order #".$row->Order->order_num. " -".$NotificationSetting->title_en,
                    'body_en' => "Order #".$row->Order->order_num. " -".$NotificationSetting->body_en,
                    'model_type' => "Order",
                    'model_id' => isset($row->order_id) ? $row->order_id : NULL,
                    'meal_id' => isset($row->meal_id) ? $row->meal_id : NULL,
                    'user_id' => $row->Order->user_id,
                ]);
                Notification::send($user_token->fcm_token, $NotificationSetting->title_ar, $NotificationSetting->body_ar, $data['model_type'], $data);
            }
        }
        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->back();
    }

    public function changeOrderMeal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:order_meals,id',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            session()->flash('success', 'حدث خطأ ما');
            return redirect()->back();
        }
        $row = OrderMeal::where('id',$request->row_id)->first();
        $meal = Meal::whereId($request->meal_id)->first();
        $row->meal_id = $request->meal_id;
        $row->meal_title_ar = $meal->title_ar;
        $row->meal_title_en = $meal->title_en;
        $row->meal_body_ar = $meal->body_ar;
        $row->meal_body_en = $meal->body_en;
        $row->save();

        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->back();
    }

    public function getData($status)
    {
        $auth = Auth::guard('admin')->user();
        $model = Order::query()->orderBy('id','desc')->where('status',$status);

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('user_name',function ($row){
                $user_name = $row->User->name;
                return '<a href="'.route('admin.users.edit',[$row->user_id]).'" target="_blank" class="" title="العميل">
                            '.$user_name.'
                        </a>';
            })
            ->editColumn('created_at',function ($row){
                return Carbon::parse($row->created_at)->format("Y-m-d (H:i) A");
            })
//            ->addColumn('select',function ($row){
//                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
//                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="'.$row->id.'" />
//                                    </div>';
//            })
            ->addColumn('actions', function ($row) use ($auth){
                $buttons = '';
//                if ($auth->can('sliders.update')) {
                    $buttons .= '<a href="'.route('admin.orders.edit',[$row->id]).'" class="btn btn-success btn-circle btn-sm m-1" title="عرض التفاصيل" target="_blank">
                            <i class="fa fa-eye"></i>
                        </a>';
//                }
//                if ($auth->can('sliders.delete')) {
//                    $buttons .= '<a class="btn btn-danger btn-sm delete btn-circle m-1" data-id="'.$row->id.'"  title="حذف">
//                            <i class="fa fa-trash"></i>
//                        </a>';
//                }
                return $buttons;
            })
            ->rawColumns(['actions','user_name','created_at'])
            ->make();

    }

    public function orderDetails(Request $request,$order_id)
    {
        $auth = Auth::guard('admin')->user();
        $model = OrderMeal::query()->orderBy('date','asc')->where('order_id',$order_id);
        if (!empty($request->meal_type)) {
            $model =$model->where('meal_type_id',$request->meal_type);
        }
        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('meal_type_name',function ($row) {
                return $row->MealType->title_ar;
            })
            ->addColumn('status',function ($row){
                if($row->status == 'pending')
                    return '<b class="badge badge-primary">قيد التوصيل</b>';
                elseif ($row->status == 'delivered')
                    return '<b class="badge badge-success">تم التوصيل</b>';

            })
            ->editColumn('date',function ($row){
                return Carbon::parse($row->date)->format("Y-m-d");
            })
            ->editColumn('old_date',function ($row){
                if($row->old_date)
                    return '<b class="badge badge-danger">'.Carbon::parse($row->old_date)->format("Y-m-d (H:i) A").'</b>';
                else
                    return '<b class="badge badge-secondary">__</b>';
            })
//            ->addColumn('select',function ($row){
//                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
//                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="'.$row->id.'" />
//                                    </div>';
//            })
            ->addColumn('actions', function ($row) use ($auth){
                $buttons = '';
//                if ($auth->can('sliders.update')) {
                $buttons .= '<a href="#" data-id="'.$row->id.'" data-status="'.$row->status.'" class="btn btn-sm btn-primary changeStatus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app" title="تغيير الحالة" id="kt_toolbar_primary_button"><i class="fa fa-edit"></i></a>';

                if(Carbon::parse($row->date) > Carbon::now() && $row->status == 'pending'){
                    $buttons .= '<a href="#" data-id="'.$row->id.'" data-mealtype="'.$row->MealType->title_ar.'" data-mealname="'.$row->meal_title_ar.'" class="btn btn-sm btn-warning m-1 changeMeal" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app2" title="تغيير الوجبة" id="kt_toolbar_primary_button2"><i class="fa fa-edit"></i></a>';
                }
//                $buttons .= '<a href="'.route('admin.orders.edit',[$row->id]).'" class="btn btn-success btn-circle btn-sm m-1" title="عرض التفاصيل" target="_blank">
//                            <i class="fa fa-eye"></i>
//                        </a>';
//                }
//                if ($auth->can('sliders.delete')) {
//                    $buttons .= '<a class="btn btn-danger btn-sm delete btn-circle m-1" data-id="'.$row->id.'"  title="حذف">
//                            <i class="fa fa-trash"></i>
//                        </a>';
//                }
                return $buttons;
            })
            ->rawColumns(['actions','status','date','old_date','meal_type_name'])
            ->make();
    }
}
