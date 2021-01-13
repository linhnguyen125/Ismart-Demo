<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserPageController extends Controller
{
    //
    function blog(){
        return view('user.page.blog');
    }

    function detail_blog(){
        return view('user.page.detail_blog');
    }
}
