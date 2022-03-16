<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Meal;
use App\Models\Offer;
use App\Models\Order;
use App\Models\Package;
use App\Models\PackageType;
use App\Models\PackageTypePrice;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
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

        return view('admin.pages.home', compact('data', 'newest_orders', 'orders_numbers_chart'));
    }
}
