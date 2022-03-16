<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\Page;
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

    public function create($type)
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

    public function edit($status)
    {

        $row = Page::where('type',$type)->first();
        if (!$row){
            session()->flash('error', 'الحقل غير موجود');
            return redirect()->back();
        }
        return view('admin.pages.orders.edit',compact('row','status'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:pages,id',
            'type' => 'required|in:about,terms,frozen',
            'body_ar' => 'required',
            'body_en' => 'required',
            'image' => 'sometimes|image|mimes:png,jpg,jpeg',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

//        if ($request->has('image') && is_file($request->image)){
//            if (!empty($city->getOriginal('image'))){
//                unlinkFile($city->getOriginal('image'), 'cities');
//            }
//        }
        $row = Page::whereId($request->row_id)->first();
        $row->update($request->except('row_id','_token','image'));
        if ($request->has('image') && is_file($request->image)){
            $row->update([ 'image' => $request->image ]);
        }
        $row->save();

        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->route('admin.orders.edit',[$request->type]);
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

    public function getData($status)
    {
        $auth = Auth::guard('admin')->user();
        $model = Order::query()->orderBy('id','desc')->where('status',$status);

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
            ->rawColumns(['actions','user_name','created_at'])
            ->make();

    }
}