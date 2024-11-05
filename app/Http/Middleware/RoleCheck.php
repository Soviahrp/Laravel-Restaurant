<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class RoleCheck
{
    public function handle(Request $request, Closure $next, $role  )
    {
        // if ($role) {
        //    dd(session('role'));
            if (session('role') !== $role) {
                abort(403, 'Unauthorized action.');
            }

        return $next($request);
    }
}

