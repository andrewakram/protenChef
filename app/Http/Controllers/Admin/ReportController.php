<?php

namespace App\Http\Controllers\Admin;

use App\Models\Coupon;
use App\Models\Meal;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderMeal;
use App\Models\Package;
use App\Models\PackageTypePrice;
use App\Models\Slider;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
{
    public function index()
    {
        $from = Carbon::now()->subDay()->format('Y-m-d');
        $to =Carbon::now()->format('Y-m-d');
        $from1 = request()->from;
        $to1 = request()->to;
        if(isset($from1) && $from1 != null ){
            $from = Carbon::parse($from1)->format('Y-m-d');
        }
        if(isset($to1) && $to1 != null ){
            $to = Carbon::parse($to1)->format('Y-m-d');
        }
        //counts for first row in page ....
        //first card
        $data['orders'] = Order::whereBetween('created_at', [$from, $to])->get()->count();
        $data['current_orders'] = Order::whereIn('status', ['pending', 'accepted'])->whereBetween('created_at', [$from, $to])->get()->count();
        $data['finished_orders'] = Order::where('status', 'finished')->whereBetween('created_at', [$from, $to])->get()->count();
        $data['canceled_orders'] = Order::where('status', 'canceled')->whereBetween('created_at', [$from, $to])->get()->count();
        //second card
        $data['canceled_orders'] = Order::where('status', 'canceled')->whereBetween('created_at', [$from, $to])->get()->count();
        $data['sum_income'] = Order::where('status', '!=', 'canceled')->whereBetween('created_at', [$from, $to])->get()->sum('total_price');
        $data['packages'] = Package::whereBetween('created_at', [$from, $to])->get();
        //third card
        $data['customers'] = User::whereBetween('created_at', [$from, $to])->get()->count();
        $data['last_customers'] = User::orderBy('created_at', 'desc')->whereBetween('created_at', [$from, $to])->take(7)->get();

        //for orders table in home page ..
        $newest_orders = Order::orderBy('id', 'desc')->whereBetween('created_at', [$from, $to])->get();

        //for order Chart
        $orders_arr[0] = $data['current_orders'];
        $orders_arr[1] = $data['finished_orders'];
        $orders_arr[2] = $data['canceled_orders'];
        $orders_numbers_chart = json_encode($orders_arr);



        return view('admin.pages.reports.index',
            compact('data', 'newest_orders', 'orders_numbers_chart','from','to'));
    }

    public function getData($from = null ,$to = null)
    {
        $auth = Auth::guard('admin')->user();
        $model = OrderMeal::query();
        if ($from != null){
            $from = Carbon::parse($from)->format('Y-m-d');
        }else{
            $from = Carbon::parse(Carbon::now()->subDay())->format('Y-m-d');
        }
        if ($to != null){
            $to = Carbon::parse($to)->format('Y-m-d');
        }else{
            $to = Carbon::parse(Carbon::now()->subDay())->format('Y-m-d');
        }
        $model->whereBetween('created_at', [$from, $to]);


        return DataTables::eloquent($model)
            ->addIndexColumn()
            ->addColumn('status',function ($row){
                if($row->status == 'pending')
                    return '<b class="badge badge-primary">قيد التوصيل</b>';
                elseif ($row->status == 'delivered')
                    return '<b class="badge badge-success">تم التوصيل</b>';

            })
            ->editColumn('date',function ($row){
                return Carbon::parse($row->date)->format("Y-m-d (H:i) A");
            })
            ->editColumn('old_date',function ($row){
                if($row->old_date)
                    return '<b class="badge badge-danger">'.Carbon::parse($row->old_date)->format("Y-m-d (H:i) A").'</b>';
                else
                    return '<b class="badge badge-secondary">__</b>';
            })
            ->addColumn('user_name',function ($row){
                $user_name = $row->Order->User->name;
                $user_id = $row->Order->User->id;
                return '<a href="'.route('admin.users.edit',[$user_id]).'" target="_blank" class="" title="العميل">
                            '.$user_name.'
                        </a>';
            })
            ->addColumn('delivery',function ($row){
                if($row->Order->lat && $row->Order->lng)
                    return '<a href="https://maps.google.com/maps?q='.$row->Order->lat.','.$row->Order->lng.'&hl=es&z=14&amp;" target="_blank" class="btn btn-primary" title="'.$row->Order->location_body.'">
                            <i class="fa fa-map"></i>
                        </a>';
                else
                    return '<b class="badge badge-secondary">من المقر</b>';
            })
            ->addColumn('actions', function ($row) use ($auth){
                $buttons = '';
                $buttons .= '<a href="#" data-id="'.$row->id.'" class="btn btn-sm btn-primary changeStatus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app" id="kt_toolbar_primary_button"><i class="fa fa-edit"></i></a>';

                return $buttons;
            })
            ->rawColumns(['actions','status','date','old_date','user_name','delivery'])
            ->make();


    }
}
