<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserContactController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'contact']);

            return $next($request);
        });
    }

    function contact()
    {

        return view('user.contact.contact');
    }
}
