<?php

namespace App\Http\Middleware;

use App\Helpers\TransJsonResponse;
use Closure;

class CompanyCheck
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
        $role = $request->user()
                        ->roles()
                        ->value('name');
        if ($role !== 'company'){
            return TransJsonResponse::toJson(false,null,
                'Only for role - company',403);
        }
        return $next($request);
    }
}
