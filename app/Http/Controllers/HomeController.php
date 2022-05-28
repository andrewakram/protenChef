<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Meal;
use App\Models\MealType;
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

        $meal_quantities = [];
        $item = [];
        $meal_quantities_query = OrderMeal::where('date',$deliverDate)
            ->select('meal_id')->distinct('meal_id')->get();
//        dd($meal_quantities_query);
        foreach ($meal_quantities_query as $meal_qty){
            $item['meal_id'] = $meal_qty->meal_id;
            $meal = Meal::whereId($meal_qty->meal_id)->first();
            $item['meal'] = isset($meal) ? $meal->title_ar : "-";
            $order_meals = OrderMeal::where('meal_id',$meal_qty->meal_id)->where('date',$deliverDate)->get();
            $item['quantity'] = sizeof($order_meals);
            $item['users'] = $order_meals;
            if($meal)
                array_push($meal_quantities,$item);
        }

        $meal_types = MealType::select('id','title_ar')->get();
        if(sizeof($meal_types) > 0){
            $meals = Meal::where('meal_type_id',$meal_types[0]->id)->select('id','title_ar')->get();
        }else{
            $meals = [];
        }

        return view('admin.pages.home',
            compact('data', 'newest_orders', 'orders_numbers_chart','date','meal_quantities',
            'meal_types','meals'));
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
                $buttons .= '<a href="#" data-id="'.$row->id.'" data-status="'.$row->status.'" data-status="'.$row->status.'" title="تغيير الحالة" class="btn btn-sm btn-primary changeStatus" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app" id="kt_toolbar_primary_button"><i class="fa fa-edit"></i></a>';

                if(Carbon::parse($row->date) > Carbon::now() && $row->status == 'pending'){
                    $buttons .= '<a href="#" data-id="'.$row->id.'" data-mealtype="'.$row->MealType->title_ar.'" data-mealname="'.$row->meal_title_ar.'" class="btn btn-sm btn-warning m-1 changeMeal" data-bs-toggle="modal" data-bs-target="#kt_modal_create_app2" title="تغيير الوجبة" id="kt_toolbar_primary_button2"><i class="fa fa-edit"></i></a>';
                }

                return $buttons;
            })
            ->rawColumns(['actions','status','date','old_date','user_name','delivery'])
            ->make();

    }
}
