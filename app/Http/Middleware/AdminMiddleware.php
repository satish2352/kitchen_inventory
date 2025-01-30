<?php

namespace App\Http\Middleware;
use App\Models\User;
use Closure;
class AdminMiddleware
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
        if (!$request->session()->exists('login_id')) {
            return redirect(route("/"));
        } 
        return $next($request);
       
    }
}
