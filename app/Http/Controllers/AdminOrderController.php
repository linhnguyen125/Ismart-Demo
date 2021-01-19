<?php

namespace App\Http\Controllers;

use App\Invoice_order;
use App\Order;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use function GuzzleHttp\Promise\all;

class AdminOrderController extends Controller
{
    //

    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'order']);

            return $next($request);
        });
    }

    function list(Request $request)
    {
        session(['action' => 'list']);
        $status = $request->input('status');
        $keyword = '';
        $list_act = array(
            'delete' => 'Xóa',
        );

        if ($request->input('keyword')) {
            $keyword = htmlspecialchars($request->input('keyword'));
        };



        if ($status == 'trash') {
            $list_act = array(
                'forceDelete' => 'Xóa vĩnh viễn',
                'restore' => 'Khôi phục'
            );

            $orders = Order::onlyTrashed()->where([['order_code', 'like', "%{$keyword}%"], ['fullname', 'like', "%{$keyword}%"]])
                ->orderBy('created_at', 'desc')->paginate(15);
        } elseif ($status == '1') {

            $orders = Order::where([['order_code', 'like', "%{$keyword}%"], ['fullname', 'like', "%{$keyword}%"], ['status', '=', '1']])
                ->orderBy('created_at', 'desc')->paginate(15);
        } elseif ($status == '2') {

            $orders = Order::where([['order_code', 'like', "%{$keyword}%"], ['fullname', 'like', "%{$keyword}%"], ['status', '=', '2']])
                ->orderBy('created_at', 'desc')->paginate(15);
        } elseif ($status == '3') {

            $orders = Order::where([['order_code', 'like', "%{$keyword}%"], ['fullname', 'like', "%{$keyword}%"], ['status', '=', '3']])
                ->orderBy('created_at', 'desc')->paginate(15);
        } else {

            $orders = Order::where([['order_code', 'like', "%{$keyword}%"], ['fullname', 'like', "%{$keyword}%"]])
                ->orderBy('created_at', 'desc')->paginate(15);
        }

        $count_order_1 = Order::where('status', '=', '1')->count();
        $count_order_2 = Order::where('status', '=', '2')->count();
        $count_order_3 = Order::where('status', '=', '3')->count();
        $count_orders_trash = Order::onlyTrashed()->count();
        $count = [$count_order_1, $count_order_2, $count_order_3, $count_orders_trash];

        return view('admin.order.list', compact('orders', 'count', 'list_act'));
    }

    function delete($id)
    {
        $order = Order::find($id);
        $order->delete();

        return redirect('admin/order/list')->with('status', 'Đã hủy đơn hàng thành công');
    }

    function forceDelete($id)
    {
        $order = Order::onlyTrashed()->where('id',$id);
        $order->forceDelete();

        return redirect('admin/order/list')->with('status', 'Đã xóa đơn hàng thành công');
    }

    function action(Request $request)
    {
        $list_check = $request->input('list_check');
        if ($list_check) {
            if (!empty($list_check)) {
                $act = $request->input('act');

                //Xóa tạm thời
                if ($act == 'delete') {
                    Order::destroy($list_check);

                    return redirect('admin/order/list')->with('status', 'Xóa sản phẩm thành công');
                }

                // Khôi phục
                if ($act == 'restore') {
                    Order::withTrashed()->whereIn('id', $list_check)
                        ->restore();

                    return redirect('admin/order/list')->with('status', 'Khôi phục đơn hàng thành công');
                }

                // Xóa vĩnh viễn
                if ($act == 'forceDelete') {
                    Order::withTrashed()->whereIn('id', $list_check)
                        ->forceDelete();

                    return redirect('admin/order/list?status=trash')->with('status', 'Đã xóa đơn hàng khỏi hệ thống');
                }

                if ($act = 'none') {
                    return redirect('admin/order/list')->with('status_err', 'Bạn cần chọn tác vụ để thao tác');
                }
            }
        } else {
            return redirect('admin/order/list')->with('status_err', 'Bạn cần chọn đơn hàng để thao tác');
        }
    }

    function detail($id)
    {
        $order = Order::find($id);
        $details = $order->invoice_orders;
        // foreach ($details as $item) {
        //     $products = $item->product;
        // }
        return view('admin.order.detail', compact('order', 'details'));
    }

    function store(Request $request, $id)
    {
        $status = $request->input('status');
        if ($status) {
            Order::where('id', $id)->update([
                'status' => $status
            ]);

            return redirect('admin/order/detail/' . $id)->with('status', 'Cập nhật trạng thái thành công');
        } else {
            return redirect('admin/order/detail/' . $id)->with('status_err', 'Cập nhật trạng thái thất bại, vui lòng thử lại');
        }
    }
}
