<?php

namespace App\Http\Controllers\Admin;

use App\Models\Slider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SliderController extends Controller
{
    public function index()
    {
        return view('admin.pages.sliders.index');
    }

    public function create()
    {
        return view('admin.pages.sliders.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'url' => 'required',
            'active' => 'required|in:0,1',
            'image' => 'required|image|mimes:png,jpg,jpeg',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $row = new Slider();
        $row->image = $request->image;
        $row->title = $request->title;
        $row->url = $request->url;
        $row->active = $request->active;
        $row->save();
            session()->flash('success', 'تم الإضافة بنجاح');
        return redirect()->route('admin.sliders');
    }

    public function edit($id)
    {

        $row = Slider::where('id',$id)->first();
        if (!$row){
            session()->flash('error', 'الحقل غير موجود');
            return redirect()->back();
        }
        return view('admin.pages.sliders.edit',compact('row'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:sliders,id',
            'title' => 'required',
            'url' => 'required',
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
        $row = Slider::whereId($request->row_id)->first();
        $row->update($request->except('row_id','_token','image'));
        if ($request->has('image') && is_file($request->image)){
            $row->update([ 'image' => $request->image ]);
        }
        $row->save();

        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->route('admin.sliders');
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:sliders,id',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['message' => 'Failed']);
        }

        $row = Slider::where('id',$request->row_id)->first();
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
        $row = Slider::where('id',$id)->first();
//        if (!empty($city->getOriginal('image'))){
//            unlinkFile($city->getOriginal('image'), 'cities');
//        }
        return $row->delete();
    }

    public function getData()
    {
        $auth = Auth::guard('admin')->user();
        $model = Slider::query();

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
                    $buttons .= '<a href="'.route('admin.sliders.edit',[$row->id]).'" class="btn btn-secondary btn-sm m-1">
                            <i class="fa fa-edit"></i>
                            تعديل
                        </a>';
//                }
//                if ($auth->can('sliders.delete')) {
                    $buttons .= '<a class="btn btn-secondary btn-sm delete m-1" data-id="'.$row->id.'"  >
                            <i class="fa fa-trash"></i>
                            حذف
                        </a>';
//                }
                return $buttons;
            })
            ->rawColumns(['actions','active','image'])
            ->make();

    }
}
