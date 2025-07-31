<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Role;

class AdminOrEmployeeMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $adminRoleId = Role::where('name', 'admin')->first()->id ?? 1;
        $employeeRoleId = Role::where('name', 'employee')->first()->id ?? 2;

        if (auth()->check() && in_array(auth()->user()->role_id, [$adminRoleId, $employeeRoleId])) {
            return $next($request);
        }

        abort(403, 'Unauthorized action.');
    }
}
