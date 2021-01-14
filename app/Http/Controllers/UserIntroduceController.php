<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserIntroduceController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'introduce']);

            return $next($request);
        });
    }

    function introduce(){

        return view('user.introduce.introduce');
    }
}
