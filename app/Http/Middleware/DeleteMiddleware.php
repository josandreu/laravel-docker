<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DeleteMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(!isset($request->token)) {
            echo 'No está definido el token<br>';
            //dd($next($request));
        }
        return $next($request);
    }
}
