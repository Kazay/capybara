<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use App\Models\User;

/**
 * Validate a role before allowing API request
 * Only works for authenticated users
 */
class AuthorizeRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $roles
     * @return mixed
     */
    public function handle($request, Closure $next, ...$roles)
    {
        $userRole = $request->user()->role;

        foreach ($roles as $role) {
            // Bitwise check of roles
            if (User::hasRole($request->user(), 'admin')) {
                return $next($request);
            }
        }

        abort(403, "Unauthorized");
    }
}