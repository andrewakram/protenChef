<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notification;
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
        return view('admin.pages.notifications.create',compact('users'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'body' => 'required',
            'model_type' => 'required|in:other,Coupon,Order,Meal,Offer',
            'user_id' => 'sometimes',
            'model_id' => 'sometimes',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        if($request->user_id){
            foreach ($request->user_id as $user_id){
                Notification::create([
                    'title' => $request->title,
                    'body' => $request->body,
                    'model_type' => $request->model_type,
                    'model_id' => isset($request->model_id) ? $request->model_id : NULL,
                    'user_id' => $request->model_id,
                ]);
            }
        }else{
            Notification::create([
                'title' => $request->title,
                'body' => $request->body,
                'model_type' => $request->model_type,
                'model_id' => $request->model_id,
            ]);
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
        $model = Notification::query();

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
                    return "<b class='badge badge-danger'>عرض</b>";
                }
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
//                    $buttons .= '<a href="'.route('admin.notifications.edit',[$row->id]).'" class="btn btn-primary btn-circle btn-sm m-1" title="تعديل">
//                            <i class="fa fa-edit"></i>
//                        </a>';
//                }
//                if ($auth->can('sliders.delete')) {
                    $buttons .= '<a class="btn btn-danger btn-sm delete btn-circle m-1" data-id="'.$row->id.'"  title="حذف">
                            <i class="fa fa-trash"></i>
                        </a>';
//                }
                return $buttons;
            })
            ->rawColumns(['actions','type','created_at'])
            ->make();

    }
}
