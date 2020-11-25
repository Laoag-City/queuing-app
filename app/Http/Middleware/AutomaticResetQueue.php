<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;

class AutomaticResetQueue
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
        if(User::WhereDate('updated_at', '<', date('Y-m-d', strtotime('now')))->get()->isNotEmpty())
        {
            $now = Carbon::now();

            DB::table('users')->update(['current_regular_queue_number' => null, 
                                        'current_pod_queue_number' => null, 
                                        'is_currently_serving_regular' => null, 
                                        'updated_at' => $now
                                    ]);
        }

        return $next($request);
    }
}
