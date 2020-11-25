<?php

namespace App\Http\Middleware;

use Closure;

class RedirectNotOwnQueueType
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
        if(!$request->user()->is_admin && $request->user()->queue_type_id != $request->segments()[1])
            return redirect('/');

        return $next($request);
    }
}
