<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\User;
use Auth;
class AdminAccess
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && Auth::user()->role == 1)
        {
            return $next($request);
        }
        else if(Auth::check() && Auth::user()->role == 2)
        {
            return $next($request);
        }
        else 
        {   
            return redirect('/adminlogin')->with('NotFound', 'You must logged in first!');
        }
    }
}
