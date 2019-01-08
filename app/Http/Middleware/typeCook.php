<?php

namespace App\Http\Middleware;

use Closure;

class typeCook
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && $request->user()->type == 'cook') {
            return $next($request);
        }
        return Response::json([
                'unauthorized' => 'Unauthorized Access! Only cookers are alowed!'
            ], 401);
    }
}
