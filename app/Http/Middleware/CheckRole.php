<?php

namespace App\Http\Middleware;

use App\User;
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
    public function handle($request, Closure $next, $role_name, $current_url)
    {
        $user = User::find(Auth::id());
        if($user->role->name != $role_name){
            return redirect($current_url)->with('status', 'Bạn không có quyền truy cập')
            ->with('class', 'alert-danger');
        }
        return $next($request);
    }
}
