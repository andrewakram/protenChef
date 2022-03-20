<?php

namespace App\Http\Controllers\Admin;

use App\Models\Meal;
use App\Models\MealType;
use App\Models\Package;
use App\Models\PackageMeal;
use App\Models\PackageMealType;
use App\Models\PackageType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class PackageMealController extends Controller
{
    public function index($package_id)
    {
        return view('admin.pages.package_meals.index',compact('package_id'));
    }

    public function create($package_id)
    {
        $packages =Package::select('id','title_ar')->get();
        $meal_types = MealType::select('id','title_ar')->get();
        if(sizeof($meal_types) > 0){
            $meals = Meal::where('meal_type_id',$meal_types[0]->id)->select('id','title_ar')->get();
        }else{
            $meals = [];
        }
        return view('admin.pages.package_meals.create',compact('meals','packages','meal_types','package_id'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'day' => 'required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',
            'week' => 'required|in:1,2',
            'meal_id' => 'required|exists:meals,id',
            'package_id' => 'required|exists:packages,id',
            'meal_type_id' => 'required|exists:meal_types,id',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $row = new PackageMeal();
        $row->day = $request->day;
        $row->week = $request->week;
        $row->meal_id = $request->meal_id;
        $row->package_id = $request->package_id;
        $row->meal_type_id = $request->meal_type_id;
        $row->save();
            session()->flash('success', 'تم الإضافة بنجاح');
        return redirect()->route('admin.package-meals',[$request->package_id]);
    }

    public function edit($id)
    {
        $packages =Package::select('id','title_ar')->get();
        $meal_types = MealType::select('id','title_ar')->get();
        if(sizeof($meal_types) > 0){
            $meals = Meal::where('meal_type_id',$meal_types[0]->id)->select('id','title_ar')->get();
        }else{
            $meals = [];
        }
        $row = PackageMeal::where('id',$id)->first();
        $package_id = $row->package_id;
        if (!$row){
            session()->flash('error', 'الحقل غير موجود');
            return redirect()->back();
        }
        return view('admin.pages.package_meals.edit',
            compact('row','package_id','packages','meal_types','meals'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:package_meals,id',
            'day' => 'required|in:Saturday,Sunday,Monday,Tuesday,Wednesday,Thursday,Friday',
            'week' => 'required|in:1,2',
            'meal_id' => 'required|exists:meals,id',
            'package_id' => 'required|exists:packages,id',
            'meal_type_id' => 'required|exists:meal_types,id',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

//        if ($request->has('image') && is_file($request->image)){
//            if (!empty($city->getOriginal('image'))){
//                unlinkFile($city->getOriginal('image'), 'cities');
//            }
//        }
        $row = PackageMeal::whereId($request->row_id)->first();
        $row->update($request->except('row_id','_token'));
        $row->save();

        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->route('admin.package-meals',[$row->package_id]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:package_meals,id',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['message' => 'Failed']);
        }

        $row = PackageMeal::where('id',$request->row_id)->first();
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
        $row = PackageMeal::where('id',$id)->first();
//        if (!empty($city->getOriginal('image'))){
//            unlinkFile($city->getOriginal('image'), 'cities');
//        }
        return $row->delete();
    }

    public function getData($package_id)
    {
        $auth = Auth::guard('admin')->user();
        $model = PackageMeal::query();
        if ($package_id > 0)
            $model->where('package_id',$package_id);

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('day',function ($row){
                if($row->day == "Saturday")
                    return "<b class='badge badge-dark'>السبت </b> ";
                elseif($row->day == "Sunday")
                    return "<b class='badge badge-dark'>الاحد </b> ";
                elseif($row->day == "Monday")
                    return "<b class='badge badge-dark'>الاثنين </b> ";
                elseif($row->day == "Tuesday")
                    return "<b class='badge badge-dark'>الثلاثاء </b> ";
                elseif($row->day == "Wednesday")
                    return "<b class='badge badge-dark'>الاربعاء </b> ";
                elseif($row->day == "Thursday")
                    return "<b class='badge badge-dark'>الخميس </b> ";
                elseif($row->day == "Friday")
                    return "<b class='badge badge-dark'>الجمعة </b> ";
            })
            ->editColumn('week',function ($row){
                if($row->week == "1")
                    return "<b class='badge badge-info'>الاسبوع الاول </b> ";
                elseif($row->week == "2")
                    return "<b class='badge badge-info'>الاسبوع الثاني </b> ";
            })
            ->addColumn('package_name',function ($row){
                return $row->Package->title_ar;
            })
            ->addColumn('meal_name',function ($row){
                return $row->Meal->title_ar;
            })
            ->addColumn('meal_type_name',function ($row){
                return $row->MealType->title_ar;
            })
//            ->addColumn('select',function ($row){
//                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
//                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="'.$row->id.'" />
//                                    </div>';
//            })
            ->addColumn('actions', function ($row) use ($auth){
                $buttons = '';
//                if ($auth->can('sliders.update')) {
                    $buttons .= '<a href="'.route('admin.package-meals.edit',[$row->id]).'" class="btn btn-primary btn-circle btn-sm m-1" title="تعديل">
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
            ->rawColumns(['actions','week','day','package_name','meal_name','meal_type_name'])
            ->make();
    }

    public function getMeals(Request $request)
    {
        $meals = Meal::where('meal_type_id',$request->meal_type_id)
            ->select('id','title_ar')->get();
        return response()->json($meals);
    }
}
