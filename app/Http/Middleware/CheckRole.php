<?php

namespace App\Http\Middleware;

use App\RolePermission;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckRole
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
        $listPermission = array();
        foreach ($user->roles as $item) {
            $listPermission[] = RolePermission::where('role_id', $item->id)->get()->pluck('permission_id')->unique();
        }
        foreach ($listPermission as $row) {
            if ($row->contains($permission)) {
                return $next($request);
            }
        }

        return abort(401);
    }
}
