<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */

    public function handle($request, Closure $next, $guard = null) {
        if (Auth::guard($guard)->check()) {
            $has = Auth::user()->hasPermissionTo('admin_dashboard');
            $is_admin = Auth::user()->hasRole('Super Admin');
            if($has || $is_admin) {
                 return redirect('/admin/dashboard');
            }
            return redirect('/admin/profile');
        }
        return $next($request);
      }
}
