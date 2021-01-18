<?php

namespace App\Http\Controllers;

use App\District;
use App\Invoice_order;
use App\Mail\ThongTinDatHang;
use App\Order;
use App\Product;
use App\Province;
use App\Ward;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

use function PHPSTORM_META\type;

class UserCheckoutController extends Controller
{
    //
    function show(Request $request)
    {
        $provinces = Province::all();
        // $districts = District::all();
        // $wards = Ward::all();

        return view('user.checkout.show', compact('provinces'));
    }

    function updateDistrict(Request $request)
    {
        $districts = District::where('province_id', '=', $request->provinceId)->get();
        echo '<option value="0" selected>------- Quận/Huyện -------</option>';
        foreach ($districts as $district) {
            echo '<option value = "' . $district->id . '">' . $district->name . '</option>';
        }
    }

    function updateWard(Request $request)
    {
        $wards = Ward::where('district_id', '=', $request->districtId)->get();
        echo '<option value="0" selected>-------- Phường/Xã --------</option>';
        foreach ($wards as $ward) {
            echo '<option value = "' . $ward->id . '">' . $ward->name . '</option>';
        }
    }

    function store(Request $request)
    {
        $request->session()->flash('fullname', $request->input('fullname'));
        $request->session()->flash('email', $request->input('email'));
        $request->session()->flash('address', $request->input('address'));
        $request->session()->flash('phone', $request->input('phone'));
        $request->session()->flash('note', $request->input('note'));

        $request->validate(
            [
                'fullname' => 'required|max:50',
                'email' => 'required|email',
                'address' => 'required',
                'note' => 'max:200',
                'province' => 'required',
                'district' => 'required',
                'ward' => 'required',
                'phone' => ['required', 'regex:/^(84|0[3|5|7|8|9])+([0-9]{8})$/'],
                'payment-method' => 'required'
            ],
            [
                'required' => ':attribute không được để trống',
                'email' => ':attribute không đúng định dạng',
                'max' => ':attribute dài nhất :max kí tự',
                'regex' => ':attribute không đúng định dạng',
            ],
            [
                'fullname' => 'Họ và tên',
                'email' => 'Email',
                'address' => 'Địa chỉ nhà riêng',
                'province' => 'Tỉnh/Thành phố',
                'district' => 'Quận/Huyện',
                'ward' => 'Phường/Xã',
                'phone' => 'Số điện thoại',
                'payment-method' => 'Hình thức thanh toán'
            ]
        );

        // get id province, district, ward
        $provinceId = $request->input('province');
        $districtId = $request->input('district');
        $wardId = $request->input('ward');

        // get name province, district, ward
        $provinceName = Province::find($provinceId);
        $districtName = District::find($districtId);
        $wardName = Ward::find($wardId);

        $orderCode = "ISM-" . Str::upper(Str::random(8));

        $orderTotal = 0;
        foreach (Cart::content() as $row) {
            $orderTotal += $row->total;
        }

        $address = $request->input('address') . ', ' . $wardName->name . ', ' . $districtName->name . ', ' . $provinceName->name;

        Order::create([
            'order_code' => $orderCode,
            // 'user_id' => Auth::id(),
            'fullname' => $request->input('fullname'),
            'phone' => $request->input('phone'),
            'total' => $orderTotal,
            'address' => $address,
            'email' => $request->input('email'),
            'payments' => $request->input('payment-method'),
        ]);

        // Lấy id đơn hàng thêm cuối cùng
        $lastOrderId = Order::orderBy('id', 'desc')->first();

        foreach (Cart::content() as $row) {
            Invoice_order::create([
                'order_id' => $lastOrderId->id,
                'product_id' => $row->id,
                'qty' => $row->qty,
                'total' => $row->total,
            ]);
        }

        if ($request->input('payment-method') == "cod") {
            $paymentMethod = "Thanh toán khi nhận hàng";
        } else {
            $paymentMethod = "Thanh toán qua Internet banking";
        }

        $data = [
            'fullname' => $request->input('fullname'),
            'email' => $request->input('email'),
            'orderCode' => $orderCode,
            'created_at' => $lastOrderId->created_at,
            'phone' => $request->input('phone'),
            'address' => $address,
            'paymentMethod' => $paymentMethod,
        ];

        Mail::to($request->input('email'))->send(new ThongTinDatHang($data));

        Cart::destroy();

        return redirect('checkout/show')->with('status', 'Đặt hàng thành công');
    }
}
