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
        $data['orders'] = Order::get()->count();
        $data['customers'] = User::get()->count();
        $data['packageTypes'] = PackageType::get()->count();
        $data['meals'] = Meal::get()->count();
        $newest_customers = User::orderBy('created_at', 'desc')->take(5)->get();
        return view('admin.pages.home',compact('data','newest_customers'));
    }
}
