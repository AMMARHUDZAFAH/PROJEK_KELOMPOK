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
        // Sales metrics
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $completedOrders = Order::where('status', 'completed')->count();
        $pendingOrders = Order::where('status', 'pending')->count();
        $processingOrders = Order::where('status', '!=', 'pending')
            ->where('status', '!=', 'completed')
            ->where('status', '!=', 'cancelled')
            ->count();

        return view('admin.dashboard', [
            // User & Product Stats
            'userCount'         => User::count(),
            'totalUsers'        => User::where('role', 'user')->count(),
            'categoryCount'     => Category::count(),
            'productCount'      => Product::count(),
            'orderCount'        => Order::count(),

            // Sales Metrics
            'totalRevenue'      => $totalRevenue,
            'completedOrders'   => $completedOrders,
            'pendingOrders'     => $pendingOrders,
            'processingOrders'  => $processingOrders,

            // Recent Data
            'latestOrders'      => Order::with('user')->latest()->take(5)->get(),
            'latestProducts'    => Product::latest()->take(5)->get(),
        ]);
    }
}
