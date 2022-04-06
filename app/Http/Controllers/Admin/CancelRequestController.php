<?php

namespace App\Http\Controllers\Admin;

use App\Models\BankData;
use App\Models\Screen;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CancelRequestController extends Controller
{
    public function index()
    {
        return view('admin.pages.cancel_requests.index');
    }

    public function getData()
    {
        $auth = Auth::guard('admin')->user();
        $model = BankData::query()->orderBy('id','desc');

        return DataTables::eloquent($model)
            ->addIndexColumn()

            ->editColumn('status',function ($row){
                if ($row->status == 0){
                    return "<b class='badge badge-success'>جديد</b>";
                }else{
                    return "<b class='badge badge-danger'>مقروء</b>";
                }
            })
            ->editColumn('created_at',function ($row){
                return Carbon::parse($row->created_at)->format("Y-m-d (H:i) A");
            })
            ->addColumn('actions', function ($row) use ($auth){
                $buttons = '';
//                if ($auth->can('sliders.update')) {
                $buttons .= '<a href="'.route('admin.orders.edit',[$row->Order->id]).'" class="btn btn-success btn-circle btn-sm m-1" title="عرض تفاصيل الطلب" target="_blank">
                            <i class="fa fa-eye"></i>
                        </a>';
//                }
//                if ($auth->can('sliders.delete')) {
                $buttons .= '<a href="#" data-id="'.$row->id.'" class="btn btn-sm btn-primary changeStatus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app" title="تغيير حالة طلب الإلغاء" id="kt_toolbar_primary_button"><i class="fa fa-edit"></i></a>';
//                }
                return $buttons;
            })
            ->rawColumns(['actions','user','status','created_at'])
            ->make();

    }

    public function changeCancelRequestStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'row_id' => 'required|exists:bank_data,id',
        ]);
        if (!is_array($validator) && $validator->fails()) {
            session()->flash('success', 'حدث خطأ ما');
            return redirect()->back();
        }

        $row = BankData::where('id',$request->row_id)->first();
        $row->update([
            'status' => $request->status,
            'notes' => $row->notes ."\n\r".Carbon::now() . ':' .$request->notes,
        ]);
        session()->flash('success', 'تم التعديل بنجاح');
        return redirect()->back();
    }
}
