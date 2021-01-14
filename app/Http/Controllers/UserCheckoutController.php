<?php

namespace App\Http\Controllers;

use App\District;
use App\Province;
use App\Ward;
use Illuminate\Http\Request;

class UserCheckoutController extends Controller
{
    //
    function show(Request $request)
    {
        $provinces = Province::all();
        $districts = District::all();
        $wards = Ward::all();

        // if ($request->provinceId) {
        //     $districts = District::where('province_id', '=', $request->provinceId)->get();
        // } else {
        //     $districts = District::where('province_id', '=', '1')->get();
        // }

        // if ($request->districtId) {
        //     $wards = Ward::where('district_id', '=', $request->districtId)->get();
        // } else {
        //     $wards = Ward::where('district_id', '=', '1')->get();
        // }

        return view('user.checkout.show', compact('provinces', 'districts', 'wards'));
    }

    function updateDistrict(Request $request){
        
    }
        
}
