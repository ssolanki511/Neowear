<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class checkLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // if (!session()->has('user_id')) {
        //     return redirect()->route('guest.signin')->with('error', 'Please login for better experience.');
        // }
        if (!session('user_id')) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please Login for better experience.',
                ], 401);
            }

            return redirect()->route('guest.signin')->with('error', 'Please login for better experience.'); // for normal page requests
        }

        return $next($request);
    }
}
