<?php

namespace App\Http\Middleware;

use App\Constants\Role;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class isOfficer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && (Auth::user()->role_id === Role::OFFICER || Auth::user()->role_id === Role::ADMIN)) {
            return $next($request);
        }

        return abort(403, 'Unauthorized');
    }
}
