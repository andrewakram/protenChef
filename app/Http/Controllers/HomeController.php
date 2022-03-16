<?php

namespace App\Http\Controllers;

use App\Models\Meal;
use App\Models\Order;
use App\Models\PackageType;
use App\Models\User;

class HomeController extends Controller
{
    public function index()
    {
        $data['orders'] = Order::select('id')->count();
        $data['customers'] = User::select('id')->count();
        $data['packageTypes'] = PackageType::select('id')->count();
        $data['meals'] = Meal::select('id')->count();
        $newest_customers = User::orderBy('id', 'desc')->take(5)->get();
        $newest_orders = Order::orderBy('id', 'desc')->take(10)->get();
        return view('admin.pages.home',
            compact('data',
            'newest_customers',
        'newest_orders'));
    }
}
