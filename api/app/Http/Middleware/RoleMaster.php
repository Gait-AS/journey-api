<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleMaster
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->role == 'master') {
            return $next($request);
        }

        return response()->json([
            'status' => false,
            'message' => 'You are not allowed to access this resource',
            'data' => null
        ], 403);
    }
}
