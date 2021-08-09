<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SetTokenFromCookie
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($token = $request->cookie('XSRF-TOKEN')) {
            $request->headers->add([
                'X-XSRF-TOKEN' => $token
            ]);
        }
        return $next($request);
    }
}
