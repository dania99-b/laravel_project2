<?php
namespace App\Http\Middleware;
use Closure;
class AdminMiddleware
{
    public function handle($request, Closure $next)
    {
        if (!backpack_user()->hasRole('admin')) {
            return redirect(backpack_url('logout'));
        }
        return $next($request);
    }
}
