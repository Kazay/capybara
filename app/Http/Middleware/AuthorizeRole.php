<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
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
        if (Auth::guard('api')->check()) {
            foreach ($roles as $role) {
                // Bitwise check of roles
                if ((User::ROLE[$role] & Auth::user()->role) != 0) {
                    return $next($request);
                }
            }

            return response()->json(['message' => 'Unauthorized'], 403);
        }

        throw new AuthenticationException('Unauthenticated.', 'api');
    }
}