<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'dashboard']);

            return $next($request);
        });
    }

    function show()
    {
        // Đơn hàng thành công
        $orderSuccessful = Order::where('status', '=', '3')->get();

        // Đơn hàng đang xử lý + vận chuyển
        $orderProcessing = Order::where('status', '<', '3')->get();

        // Đơn hàng hủy
        $orderCancel = Order::onlyTrashed();

        // Doanh số
        $sales = Order::where('status', '=', '3')->sum('total');

        // Đơn hàng mới
        $orders = Order::orderBy('created_at', 'desc')->paginate(15);

        // return number_format($sales, 0, '', '.');

        return view('admin.dashboard', compact('orderSuccessful', 'orderProcessing', 'orderCancel', 'sales', 'orders'));
    }
}
