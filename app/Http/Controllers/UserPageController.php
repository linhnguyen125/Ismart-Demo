<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class UserPageController extends Controller
{
    //
    function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'blog']);

            return $next($request);
        });
    }

    function blog(){
        $posts = Post::where('post_status_id','=','2')->paginate('6');

        return view('user.page.blog', compact('posts'));
    }

    function detail_blog($id){
        $post = Post::find($id);

        return view('user.page.detail_blog', compact('post'));
    }
}
