<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Meal;
use App\Models\Offer;
use App\Models\Order;
use App\Models\OrderMeal;
use App\Models\Package;
use App\Models\PackageType;
use App\Models\PackageTypePrice;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class HomeController extends Controller
{
    public function index($date = null)
    {
        //counts for first row in page ....
        //first card
        $data['orders'] = Order::get()->count();
        $data['current_orders'] = Order::whereIn('status', ['pending', 'accepted'])->get()->count();
        $data['finished_orders'] = Order::where('status', 'finished')->get()->count();
        $data['canceled_orders'] = Order::where('status', 'canceled')->get()->count();
        //second card
        $data['canceled_orders'] = Order::where('status', 'canceled')->get()->count();
        $data['sum_income'] = Order::where('status', '!=', 'canceled')->get()->sum('total_price');
        $data['packages'] = Package::get();
        //third card
        $data['customers'] = User::get()->count();
        $data['last_customers'] = User::orderBy('created_at', 'desc')->take(7)->get();

        //counts for second row in page ....
        $data['meals'] = Meal::get()->count();
        $data['offers'] = Offer::active()->get()->count();
        $data['coupons'] = Coupon::get()->count();
        $data['price_plans'] = PackageTypePrice::active()->get()->count();

        //for orders table in home page ..
        $newest_orders = Order::orderBy('id', 'desc')->take(10)->get();

        //for order Chart
        $orders_arr[0] = $data['current_orders'];
        $orders_arr[1] = $data['finished_orders'];
        $orders_arr[2] = $data['canceled_orders'];
        $orders_numbers_chart = json_encode($orders_arr);

        $date = Carbon::now()->format('Y-m-d');
        $deliverDate = request()->date;
        if(isset($deliverDate) && $deliverDate != null){
            $date = Carbon::parse($deliverDate)->format('Y-m-d');
        }

        return view('admin.pages.home',
            compact('data', 'newest_orders', 'orders_numbers_chart','date'));
    }

    public function getData($date = null)
    {
        $auth = Auth::guard('admin')->user();
        $model = OrderMeal::query();
        if ($date != null){
            $deliverDate = Carbon::parse($date)->format('Y-m-d');
        }else{
            $deliverDate = Carbon::parse(Carbon::now())->format('Y-m-d');
        }
        $model->where('date',$deliverDate);


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
            ->addColumn('actions', function ($row) use ($auth){
                $buttons = '';
                $buttons .= '<a href="#" data-id="'.$row->id.'" class="btn btn-sm btn-primary changeStatus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app" id="kt_toolbar_primary_button"><i class="fa fa-edit"></i></a>';

                return $buttons;
            })
            ->rawColumns(['actions','status','date','old_date'])
            ->make();

    }
}
