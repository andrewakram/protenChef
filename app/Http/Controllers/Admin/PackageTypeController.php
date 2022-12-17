<?php

namespace App\Http\Controllers\Admin;

use App\Models\PackageType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PackageTypeController extends Controller
{
    public function index()
    {
        return view('admin.pages.package_types.index');
    }

    public function details($id)
    {
        $packageType = PackageType::findOrFail($id);
        return view('admin.pages.package_types.sub_types',compact('packageType'));
    }

    public function create($parent_id)
    {
        $packageType = PackageType::findOrFail($parent_id);

        return view('admin.pages.package_types.create',compact('packageType'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title_ar' => 'required',
            'title_en' => 'required',
            // 'days_count' => 'required',
            // 'type' => 'required|in:1,2,3,4,5',
            'image' => 'required|image|mimes:png,jpg,jpeg',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $row = new PackageType();
        $row->image = $request->image;
        $row->title_ar = $request->title_ar;
        $row->title_en = $request->title_en;
        // $row->url = $request->url;
        // $row->active = $request->active;
        $row->meal_count = $request->meal_count;
        $row->parent_id = $request->parent_id;
        $row->save();
        session()->flash('success', 'تم الإضافة بنجاح');
        return redirect()->route('admin.package-types.details',[$request->parent_id]);
    }

    public function edit($id)
    {

        $row = PackageType::where('id',$id)->first();
        if (!$row){
            session()->flash('error', 'الحقل غير موجود');
            return redirect()->back();
        }
        return view('admin.pages.package_types.edit',compact('row'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:package_types,id',
            'title_ar' => 'required',
            'title_en' => 'required',
//            'days_count' => 'required',
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
        $row = PackageType::whereId($request->row_id)->first();
        $row->update($request->except('row_id','_token','image','days_count'));
        if ($request->has('image') && is_file($request->image)){
            $row->update([ 'image' => $request->image ]);
        }
        $row->save();

        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->route('admin.package-types');
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:package_types,id',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['message' => 'Failed']);
        }

        $row = PackageType::where('id',$request->row_id)->first();
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
        $row = PackageType::where('id',$id)->first();
//        if (!empty($city->getOriginal('image'))){
//            unlinkFile($city->getOriginal('image'), 'cities');
//        }
        return $row->delete();
    }

    public function getData()
    {
        $auth = Auth::guard('admin')->user();
        $model = PackageType::query();
        $model->whereNull('parent_id');
        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('image',function ($row){
                return '<a class="symbol symbol-50px"><span class="symbol-label" style="background-image:url('.$row->image.');"></span></a>';
            })
            ->editColumn('days_count',function ($row){
                return "<b class='badge badge-dark'>$row->days_count</b>";
            })
//            ->addColumn('select',function ($row){
//                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
//                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="'.$row->id.'" />
//                                    </div>';
//            })
            ->addColumn('actions', function ($row) use ($auth){
                $buttons = '';
//                if ($auth->can('sliders.update')) {
                $buttons .= '<a href="'.route('admin.package-types.details',[$row->id]).'" class="btn btn-warning btn-circle btn-sm m-1" title="عرض">
                            <i class="fa fa-eye"></i>
                        </a>';
                $buttons .= '<a href="'.route('admin.package-types.edit',[$row->id]).'" class="btn btn-primary btn-circle btn-sm m-1" title="تعديل">
                            <i class="fa fa-edit"></i>
                        </a>';

//                }
//                if ($auth->can('sliders.delete')) {
//                    $buttons .= '<a class="btn btn-danger btn-sm delete btn-circle m-1" data-id="'.$row->id.'"  title="حذف">
//                            <i class="fa fa-trash"></i>
//                        </a>';
//                }
                return $buttons;
            })
            ->rawColumns(['actions','days_count','image'])
            ->make();

    }

    public function getDataDetails($id)
    {
        $auth = Auth::guard('admin')->user();
        $model = PackageType::query();
        $model->where('parent_id',$id);
        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('image',function ($row){
                return '<a class="symbol symbol-50px"><span class="symbol-label" style="background-image:url('.$row->image.');"></span></a>';
            })
            ->editColumn('days_count',function ($row){
                return "<b class='badge badge-dark'>$row->days_count</b>";
            })
//            ->addColumn('select',function ($row){
//                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
//                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="'.$row->id.'" />
//                                    </div>';
//            })
            ->addColumn('actions', function ($row) use ($auth){
                $buttons = '';
//                if ($auth->can('sliders.update')) {
                $buttons .= '<a href="'.route('admin.package-types.edit',[$row->id]).'" class="btn btn-primary btn-circle btn-sm m-1" title="تعديل">
                            <i class="fa fa-edit"></i>
                        </a>';

//                }
//                if ($auth->can('sliders.delete')) {
//                    $buttons .= '<a class="btn btn-danger btn-sm delete btn-circle m-1" data-id="'.$row->id.'"  title="حذف">
//                            <i class="fa fa-trash"></i>
//                        </a>';
//                }
                return $buttons;
            })
            ->rawColumns(['actions','days_count','image'])
            ->make();

    }
}
