<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {

        // return $next($request);


        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            if ($guard == 'admin' && Auth::guard($guard)->check()) {
                return redirect(RouteServiceProvider::ADMIN_HOME);
            }
            if (Auth::guard($guard)->check()) {
                // return redirect(RouteServiceProvider::HOME);

                if(Auth::user()->user_type == 1)
                {
                    return redirect(RouteServiceProvider::ADMIN_HOME);
                }
                else if(Auth::user()->user_type == 2)
                {
                    return redirect(RouteServiceProvider::TEACHER_HOME);
                }
                else if(Auth::user()->user_type == 3)
                {
                    return redirect(RouteServiceProvider::STUDENT_HOME);
                }
                else if(Auth::user()->user_type == 4)
                {
                    return redirect(RouteServiceProvider::PARENT_HOME);
                }
            }
        }

        return $next($request);
    }
}
