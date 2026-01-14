<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (! auth()->check()) {
            return redirect()->route('login');
        }

        $user = auth()->user();

        // Debug: Log user role
        \Log::info('User role check', [
            'user_id' => $user->id,
            'user_role' => $user->role,
            'required_roles' => $roles,
            'role_match' => in_array($user->role, $roles),
        ]);

        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        abort(403, 'Anda tidak memiliki akses ke halaman ini. Role Anda: '.$user->role.', Role yang dibutuhkan: '.implode(', ', $roles));
    }
}
