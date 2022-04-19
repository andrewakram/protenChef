<?php

namespace App\Http\Controllers\Admin;

use App\Models\Meal;
use App\Models\MealImage;
use App\Models\MealType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MealController extends Controller
{
    public function index($meal_type_id)
    {
        return view('admin.pages.meals.index',compact('meal_type_id'));
    }

    public function create($meal_type_id)
    {
        $meal_types = MealType::select('id','title_ar')->get();
        return view('admin.pages.meals.create',compact('meal_types','meal_type_id'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'meal_type_id' => 'required|exists:meal_types,id',
            'title_ar' => 'required',
            'title_en' => 'required',
            'body_ar' => 'required',
            'body_en' => 'required',
            'image' => 'required|image|mimes:png,jpg,jpeg',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return redirect()->back()->withErrors($validator);
        }

        $row = Meal::create([
            'meal_type_id' => $request->meal_type_id,
            'title_ar' => $request->title_ar,
            'title_en' => $request->title_en,
            'body_ar' => $request->body_ar,
            'body_en' => $request->body_en,
        ]);
        //
        $row2 = new MealImage();
        $row2->meal_id = $row->id;
        $row2->image = $request->image;
        $row2->save();
        //
        session()->flash('success', 'تم الإضافة بنجاح');
        return redirect()->route('admin.meals',[$request->meal_type_id]);
    }

    public function edit($id)
    {
        $meal_types = MealType::select('id','title_ar')->get();
        $row = Meal::where('id',$id)->first();
        if (!$row){
            session()->flash('error', 'الحقل غير موجود');
            return redirect()->back();
        }
        return view('admin.pages.meals.edit',compact('row','meal_types'));
    }

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:meals,id',
            'meal_type_id' => 'required|exists:meal_types,id',
            'title_ar' => 'required',
            'title_en' => 'required',
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
        $row = Meal::whereId($request->row_id)->first();
        $row->update($request->except('row_id','_token','image'));
        $row->save();
        if ($request->has('image') && is_file($request->image)){
            $row2=MealImage::where('meal_id',$request->row_id)->first();
            if($row2){
                $row2->update([ 'image' => $request->image ]);
                $row2->save();
            }else{
                $row2 = new MealImage();
                $row2->meal_id = $row->id;
                $row2->image = $request->image;
                $row2->save();
            }
        }

        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->route('admin.meals',[$request->meal_type_id]);
    }

    public function delete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:meals,id',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            return response()->json(['message' => 'Failed']);
        }

        $row = Meal::where('id',$request->row_id)->first();
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
        $row = Meal::where('id',$id)->first();
//        if (!empty($city->getOriginal('image'))){
//            unlinkFile($city->getOriginal('image'), 'cities');
//        }
        return $row->delete();
    }

    public function getData($meal_type_id)
    {
        $auth = Auth::guard('admin')->user();
        $model = Meal::query();
        if ($meal_type_id > 0)
            $model->where('meal_type_id',$meal_type_id);

        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->editColumn('image',function ($row){
                $MealImage = $row->Image;
                if($MealImage){
                    return '<a class="symbol symbol-50px"><span class="symbol-label" style="background-image:url('.$MealImage->image.');"></span></a>';
                }else{
                    $image = asset('default.png');
                    return '<a class="symbol symbol-50px"><span class="symbol-label" style="background-image:url('.$image.');"></span></a>';

                }
            })
//            ->addColumn('select',function ($row){
//                return '<div class="form-check form-check-sm form-check-custom form-check-solid me-3">
//                                        <input class="form-check-input" type="checkbox" data-kt-check="true" data-kt-check-target="#kt_ecommerce_products_table .form-check-input" value="'.$row->id.'" />
//                                    </div>';
//            })body_ar
            ->editColumn('meal_type_name',function ($row){
                return $row->MealType->title_ar;
            })

            ->addColumn('actions', function ($row) use ($auth){
                $buttons = '';
//                if ($auth->can('sliders.update')) {
                    $buttons .= '<a href="'.route('admin.meals.edit',[$row->id]).'" class="btn btn-primary btn-circle btn-sm m-1" title="تعديل">
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
            ->rawColumns(['actions','image','meal_type_name'])
            ->make();

    }
}
