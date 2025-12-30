<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class HomePageMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try{

            $user = Auth::user();
            if($user->role == 'admin') {
                return redirect()->route('admin.dashboard');
            } elseif($user->role == 'vendor') {
                return redirect()->route('vendor.dashboard');
            }else {
                return redirect()->route('home');
            }
            return $next($request);
        }catch(\Exception $e){
        return $next($request);
    }
}
}