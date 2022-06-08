<?php

namespace App\Http\Controllers\Admin;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class OfferController extends Controller
{
    public function index()
    {
        return view('admin.pages.offers.index');
    }

    public function create()
    {
        return view('admin.pages.offers.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar' => 'required',
            'title_en' => 'required',
            'body_ar' => 'required',
            'body_en' => 'required',
            'date' => 'required',
            'active' => 'required|in:0,1',
            'image' => 'required|image|mimes:png,jpg,jpeg',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $row = new Offer();
        $row->image = $request->image;
        $row->title_ar = $request->title_ar;
        $row->title_en = $request->title_en;
        $row->body_ar = $request->body_ar;
        $row->body_en = $request->body_en;
        $row->date = $request->date;
        $row->active = $request->active;
        $row->save();
        session()->flash('success', 'تم الإضافة بنجاح');
        return redirect()->route('admin.offers');
    }

    public function edit($id)
    {

        $row = Offer::findOrFail($id);
        if (!$row){
            session()->flash('error', 'الحقل غير موجود');
            return redirect()->back();
        }
        return view('admin.pages.offers.edit',compact('row'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:offers,id',
            'title_ar' => 'required',
            'title_en' => 'required',
            'body_ar' => 'required',
            'body_en' => 'required',
            'date' => 'required',
            'active' => 'required|in:0,1',
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
        $row = Offer::whereId($request->row_id)->first();
        $row->update($request->except('row_id','_token','image'));
        if ($request->has('image') && is_file($request->image)){
            $row->update([ 'image' => $request->image ]);
        }
        $row->save();

        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->route('admin.offers');
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:sliders,id',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['message' => 'Failed']);
        }

        $row = Offer::where('id',$request->row_id)->first();
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
        $row = Offer::where('id',$id)->first();
//        if (!empty($city->getOriginal('image'))){
//            unlinkFile($city->getOriginal('image'), 'cities');
//        }
        return $row->delete();
    }

    public function getData()
    {
        $auth = Auth::guard('admin')->user();
        $model = Offer::query();

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
//            ->addColumn('select',function ($row){
//                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
//                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="'.$row->id.'" />
//                                    </div>';
//            })
            ->addColumn('actions', function ($row) use ($auth){
                $buttons = '';
//                if ($auth->can('sliders.update')) {
                    $buttons .= '<a href="'.route('admin.offers.edit',[$row->id]).'" class="btn btn-primary btn-sm btn-circle m-1" title="تعديل">
                            <i class="fa fa-edit"></i>
                        </a>';
//                }
//                if ($auth->can('sliders.delete')) {
                    $buttons .= '<a class="btn btn-danger btn-sm delete btn-circle m-1" data-id="'.$row->id.'" title="حذف">
                            <i class="fa fa-trash"></i>
                        </a>';
//                }
                return $buttons;
            })
            ->rawColumns(['actions','active','image'])
            ->make();

    }
}
