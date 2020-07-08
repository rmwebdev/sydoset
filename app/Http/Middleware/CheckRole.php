<?php

namespace App\Http\Middleware;


use Illuminate\Support\Facades\Session;
use Closure;
use Log;
class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        $roleUser = Session::get('role');
        Log::info($roleUser);
        
        Log::info($role);

        if(strpos($role, $roleUser) !== false){
            return $next($request);
        } else{
            abort(401, 'This action is unauthorized.');
        }
        
    }
}
