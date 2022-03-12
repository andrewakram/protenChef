<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CouponController extends Controller
{
    public function index()
    {
        return view('admin.pages.coupons.index');
    }

    public function create()
    {
        return view('admin.pages.coupons.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'code' => 'required',
            'type' => 'required|in:fixed,percent',
            'amount' => 'required|numeric|min:1',
            'min_order_total' => 'required|numeric|min:1',
            'expired_at' => 'required',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $row = new Coupon();
        $row->code = $request->code;
        $row->type = $request->type;
        $row->amount = $request->amount;
        $row->min_order_total = $request->min_order_total;
        $row->expired_at = $request->expired_at;
        $row->save();
            session()->flash('success', 'تم الإضافة بنجاح');
        return redirect()->route('admin.coupons');
    }

    public function edit($id)
    {

        $row = Coupon::where('id',$id)->first();
        if (!$row){
            session()->flash('error', 'الحقل غير موجود');
            return redirect()->back();
        }
        return view('admin.pages.coupons.edit',compact('row'));
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
        $row = Coupon::whereId($request->row_id)->first();
        $row->update($request->except('row_id','_token'));
        $row->save();

        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->route('admin.coupons');
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:coupons,id',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['message' => 'Failed']);
        }

        $row = Coupon::where('id',$request->row_id)->first();
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
        $row = Coupon::where('id',$id)->first();
//        if (!empty($city->getOriginal('image'))){
//            unlinkFile($city->getOriginal('image'), 'cities');
//        }
        return $row->delete();
    }

    public function getData()
    {
        $auth = Auth::guard('admin')->user();
        $model = Coupon::query();

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('image',function ($row){
                return '<a class="symbol symbol-50px"><span class="symbol-label" style="background-image:url('.$row->image.');"></span></a>';
            })
            ->editColumn('type',function ($row){
                if ($row->type == "fixed"){
                    return "<b class='badge badge-success'>خصم ثابت</b>";
                }else{
                    return "<b class='badge badge-danger'>خصم نسبة</b>";
                }
            })
            ->editColumn('amount',function ($row){
                return "<b class='badge badge-dark'>$row->amount </b> " ." ريال";
            })
            ->editColumn('min_order_total',function ($row){
                return "<b class='badge badge-dark'>$row->min_order_total </b> " ." ريال";
            })
//            ->addColumn('select',function ($row){
//                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
//                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="'.$row->id.'" />
//                                    </div>';
//            })
            ->addColumn('actions', function ($row) use ($auth){
                $buttons = '';
//                if ($auth->can('sliders.update')) {
//                    $buttons .= '<a href="'.route('admin.coupons.edit',[$row->id]).'" class="btn btn-primary btn-circle btn-sm m-1" title="تعديل">
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
            ->rawColumns(['actions','type','amount','min_order_total'])
            ->make();

    }
}
