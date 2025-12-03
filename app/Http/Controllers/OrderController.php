<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $items = $order->items()->with('product')->get();
        return view('orders.show', compact('order', 'items'));
    }

    public function adminIndex()
    {
        $orders = Order::with('user')
            ->latest()
            ->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    public function adminShow(Order $order)
    {
        $items = $order->items()->with('product')->get();
        return view('admin.orders.show', compact('order', 'items'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:pending,paid,processing,shipped,completed,cancelled',
        ]);

        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan diperbarui.');
    }
}
