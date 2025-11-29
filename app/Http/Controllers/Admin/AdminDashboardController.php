<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $completedOrders = Order::where('status', 'completed')->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', 'processing')->count();

        return view('admin.dashboard', [
            'userCount'       => User::count(),
            'totalUsers'      => User::count(),
            'categoryCount'   => Category::count(),
            'productCount'    => Product::count(),
            'orderCount'      => Order::count(),
            'totalRevenue'    => $totalRevenue,
            'completedOrders' => $completedOrders,
            'pendingOrders'   => $pendingOrders,
            'processingOrders'=> $processingOrders,
            'latestOrders'    => Order::latest()->take(5)->get(),
            'latestProducts'  => Product::latest()->take(5)->get(),
        ]);
    }
}
