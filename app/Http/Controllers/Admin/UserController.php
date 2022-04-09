<?php

namespace App\Http\Controllers\Admin;

use App\Models\BankData;
use App\Models\Order;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.pages.users.index');
    }


    public function create()
    {
        return view('admin.pages.users.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'type' => 'required|in:fixed,percent',
            'amount' => 'required|numeric|min:1',
            'min_order_total' => 'required|numeric|min:1',
            'expired_at' => 'required',
            'user_id' => 'sometimes',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $row = User::create([
            'code' => $request->code,
            'type' => $request->type,
            'amount' => $request->amount,
            'min_order_total' => $request->min_order_total,
            'expired_at' => $request->expired_at,
        ]);
        if(sizeof($request->user_id) > 0){
            foreach ($request->user_id as $user_id){
                User::create([
                    'user_id' => $user_id ,
                    'coupon_id' => $row->id ,
                    'used' => 0,
                ]);
            }
        }
            session()->flash('success', 'تم الإضافة بنجاح');
        return redirect()->route('admin.users');
    }

    public function edit($id)
    {
        $row = User::where('id',$id)->first();
        if (!$row){
            session()->flash('error', 'الحقل غير موجود');
            return redirect()->back();
        }
        return view('admin.pages.users.edit',compact('row'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:users,id',
            'active' => 'required|in:0,1',
            'suspend' => 'required|in:0,1',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

//        if ($request->has('image') && is_file($request->image)){
//            if (!empty($city->getOriginal('image'))){
//                unlinkFile($city->getOriginal('image'), 'cities');
//            }
//        }
        $row = User::whereId($request->row_id)->first();
        $row->update(['active' => $request->active , 'suspend' => $request->suspend]);
        $row->save();

        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->route('admin.users');
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:coupons,id',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['message' => 'Failed']);
        }

        $row = User::where('id',$request->row_id)->first();
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
        $row = User::where('id',$id)->first();
//        if (!empty($city->getOriginal('image'))){
//            unlinkFile($city->getOriginal('image'), 'cities');
//        }
        return $row->delete();
    }

    public function getData()
    {
        $auth = Auth::guard('admin')->user();
        $model = User::query();

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('image',function ($row){
                return '<a class="symbol symbol-50px"><span class="symbol-label" style="background-image:url('.$row->image.');"></span></a>';
            })
            ->editColumn('active',function ($row){
                if ($row->active == 1){
                    return "<b class='badge badge-success'>مفعل</b>";
                }else{
                    return "<b class='badge badge-danger'>غير مفعل</b>";
                }
            })
            ->editColumn('suspend',function ($row){
                if ($row->suspend == 1){
                    return "<b class='badge badge-success'>موقوف</b>";
                }else{
                    return "<b class='badge badge-danger'>غير موفوف</b>";
                }
            })
            ->editColumn('created_at',function ($row){
                return Carbon::parse($row->created_at)->translatedFormat("Y-m-d (h:i) a");
            })
//            ->addColumn('select',function ($row){
//                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
//                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="'.$row->id.'" />
//                                    </div>';
//            })
            ->addColumn('actions', function ($row) use ($auth){
                $buttons = '';
//                if ($auth->can('sliders.update')) {
                    $buttons .= '<a href="'.route('admin.users.edit',[$row->id]).'" class="btn btn-primary btn-circle btn-sm m-1" title="تعديل">
                            <i class="fa fa-edit"></i>
                        </a>';
//                }
//                if ($auth->can('sliders.delete')) {
                    $buttons .= '<a href="'.route('admin.users.orders',[$row->id]).'" class="btn btn-warning btn-sm btn-circle m-1" title="الطلبات">
                            <i class="fa fa-cart-plus"></i>
                        </a>';
//                }
                $buttons .= '<a href="'.route('admin.users.cancelRequests',[$row->id]).'" class="btn btn-danger btn-sm btn-circle m-1" title="طلبات الإلغاء">
                            <i class="fa fa-recycle"></i>
                        </a>';
                return $buttons;
            })
            ->rawColumns(['actions','active','suspend','created_at'])
            ->make();

    }


    public function userOrders($user_id)
    {
        $user_name = User::whereId($user_id)->select('name')->first()->name;
        return view('admin.pages.users.orders',compact('user_id','user_name'));
    }

    public function getUserOrdersData($user_id)
    {
        $auth = Auth::guard('admin')->user();
        $model = Order::query()->orderBy('id','desc')->where('user_id',$user_id);

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('user_name',function ($row){
                $user_name = $row->User->name;
                return '<a href="'.route('admin.users.edit',[$row->user_id]).'" class="" title="العميل">
                            '.$user_name.'
                        </a>';
            })
            ->editColumn('created_at',function ($row){
                return Carbon::parse($row->created_at)->format("Y-m-d (H:i) A");
            })
            ->editColumn('status',function ($row){
                if($row->status == 'pending')
                    return "<b class='badge badge-warning'>قيد الموافقة</b>";
                elseif($row->status == 'accepted')
                    return "<b class='badge badge-success'>مقبول</b>";
                elseif($row->status == 'canceled')
                    return "<b class='badge badge-danger'>ملغي</b>";
                elseif($row->status == 'finished')
                    return "<b class='badge badge-info'>منتهي</b>";

            })
//            ->addColumn('select',function ($row){
//                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
//                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="'.$row->id.'" />
//                                    </div>';
//            })
            ->addColumn('actions', function ($row) use ($auth){
                $buttons = '';
//                if ($auth->can('sliders.update')) {
                $buttons .= '<a href="'.route('admin.orders.edit',[$row->id]).'" class="btn btn-success btn-circle btn-sm m-1" title="عرض التفاصيل">
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
            ->rawColumns(['actions','user_name','created_at','status'])
            ->make();
    }

    public function userCancelRequests($user_id)
    {
        $user_name = User::whereId($user_id)->select('name')->first()->name;
        return view('admin.pages.users.cancel_requests',compact('user_id','user_name'));
    }

    public function getCancelRequestsData($user_id)
    {
        $auth = Auth::guard('admin')->user();
        $orders = Order::where('user_id',$user_id)->pluck('id');
        $model = BankData::query()->orderBy('id','desc')->whereIn('order_id',$orders);

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('user_name',function ($row){
                $user_name = $row->User->name;
                return '<a href="'.route('admin.users.edit',[$row->user_id]).'" class="" title="العميل">
                            '.$user_name.'
                        </a>';
            })
            ->editColumn('created_at',function ($row){
                return Carbon::parse($row->created_at)->format("Y-m-d (H:i) A");
            })
            ->editColumn('status',function ($row){
                if($row->status == 'pending')
                    return "<b class='badge badge-warning'>قيد الموافقة</b>";
                elseif($row->status == 'accepted')
                    return "<b class='badge badge-success'>مقبول</b>";
                elseif($row->status == 'canceled')
                    return "<b class='badge badge-danger'>ملغي</b>";
                elseif($row->status == 'finished')
                    return "<b class='badge badge-info'>منتهي</b>";

            })
//            ->addColumn('select',function ($row){
//                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
//                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="'.$row->id.'" />
//                                    </div>';
//            })
            ->addColumn('actions', function ($row) use ($auth){
                $buttons = '';
//                if ($auth->can('sliders.update')) {
                $buttons .= '<a href="'.route('admin.orders.edit',[$row->id]).'" class="btn btn-success btn-circle btn-sm m-1" title="عرض التفاصيل">
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
            ->rawColumns(['actions','user_name','created_at','status'])
            ->make();
    }

}
