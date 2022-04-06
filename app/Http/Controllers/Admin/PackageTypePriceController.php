<?php

namespace App\Http\Controllers\Admin;

use App\Models\Package;
use App\Models\PackageType;
use App\Models\PackageTypePrice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PackageTypePriceController extends Controller
{
    public function index($package_id)
    {
        return view('admin.pages.package_type_prices.index',compact('package_id'));
    }

    public function create($package_id)
    {
        $packages = Package::select('id','title_ar')->get();
        $package_types = PackageType::select('id','title_ar')->get();
        return view('admin.pages.package_type_prices.create',compact('packages','package_types','package_id'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'package_id' => 'required|exists:packages,id',
            'package_type_id' => 'required|exists:package_types,id',
            'price' => 'required',
            'active' => 'required|in:0,1',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $row = new PackageTypePrice();
        $row->package_id = $request->package_id;
        $row->package_type_id = $request->package_type_id;
        $row->price = $request->price;
        $row->active = $request->active;
        $row->save();
            session()->flash('success', 'تم الإضافة بنجاح');
        return redirect()->route('admin.package-type-prices',[$request->package_id]);
    }

    public function edit($id)
    {
        $packages = Package::select('id','title_ar')->get();
        $package_types = PackageType::select('id','title_ar')->get();
        $row = PackageTypePrice::where('id',$id)->first();
        if (!$row){
            session()->flash('error', 'الحقل غير موجود');
            return redirect()->back();
        }
        return view('admin.pages.package_type_prices.edit',compact('row','packages','package_types'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:package_type_prices,id',
            'package_id' => 'required|exists:packages,id',
            'package_type_id' => 'required|exists:package_types,id',
            'price' => 'required',
            'active' => 'required|in:0,1',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

//        if ($request->has('image') && is_file($request->image)){
//            if (!empty($city->getOriginal('image'))){
//                unlinkFile($city->getOriginal('image'), 'cities');
//            }
//        }
        $row = PackageTypePrice::whereId($request->row_id)->first();
        $row->update($request->except('row_id','_token'));
        $row->save();

        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->route('admin.package-type-prices',[$row->package_id]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:package_type_prices,id',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['message' => 'Failed']);
        }

        $row = PackageTypePrice::where('id',$request->row_id)->first();
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
        $row = PackageTypePrice::where('id',$id)->first();
//        if (!empty($city->getOriginal('image'))){
//            unlinkFile($city->getOriginal('image'), 'cities');
//        }
        return $row->delete();
    }

    public function getData($package_id)
    {
        $auth = Auth::guard('admin')->user();
        $model = PackageTypePrice::query()->orderBy('id',"desc");
        if ($package_id > 0)
            $model->where('package_id',$package_id);

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('active',function ($row){
                if ($row->active == 1){
                    return "<b class='badge badge-success'>مفعل</b>";
                }else{
                    return "<b class='badge badge-danger'>غير مفعل</b>";
                }
            })
            ->editColumn('price',function ($row){
                return "<b class='badge badge-dark'>$row->price </b> " ." ريال";
            })
            ->editColumn('min_order_total',function ($row){
                return "<b class='badge badge-dark'>$row->min_order_total </b> " ." ريال";
            })
            ->editColumn('package_name',function ($row){
                return $row->Package->title_ar;
            })
            ->editColumn('package_type_name',function ($row){
                return $row->PackageType->title_ar;
            })
//            ->addColumn('select',function ($row){
//                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
//                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="'.$row->id.'" />
//                                    </div>';
//            })
            ->addColumn('actions', function ($row) use ($auth){
                $buttons = '';
//                if ($auth->can('sliders.update')) {
                    $buttons .= '<a href="'.route('admin.package-type-prices.edit',[$row->id]).'" class="btn btn-primary btn-circle btn-sm m-1" title="تعديل">
                            <i class="fa fa-edit"></i>
                        </a>';
//                }
//                if ($auth->can('sliders.delete')) {
                    $buttons .= '<a class="btn btn-danger btn-sm delete btn-circle m-1" data-id="'.$row->id.'"  title="حذف">
                            <i class="fa fa-trash"></i>
                        </a>';
//                }
                return $buttons;
            })
            ->rawColumns(['actions','active','price','package_name','package_type_name'])
            ->make();

    }
}
