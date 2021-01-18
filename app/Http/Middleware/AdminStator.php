<?php

namespace App\Http\Middleware;

use App\RolePermission;
use Closure;
use Illuminate\Support\Facades\Auth;

class AdminStator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $permission = null)
    {
        $user = Auth::user();
        foreach ($user->roles as $item) {
            if($item->id == $permission){
                return $next($request);
            }
        }

        return abort(401);
    }
}
