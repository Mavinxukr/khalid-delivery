<?php

namespace App\Http\Middleware;

use App\Helpers\TransJsonResponse;
use Closure;

class CompanyUser
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
        if ($role !== 'user'){
            return TransJsonResponse::toJson(false,null,
                'Only for role - user',403);
        }
        return $next($request);
    }
}
