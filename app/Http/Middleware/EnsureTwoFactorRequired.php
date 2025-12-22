<?php

namespace App\Http\Middleware;

use App\Models\Setting;
use Closure;
use Illuminate\Http\Request;

class EnsureTwoFactorRequired
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        // Skip if not authenticated
        if (!$user) {
            return $next($request);
        }

        $requireAll = (bool) Setting::get('require_2fa_for_all', '0');
        $userRequired = (bool) ($user->two_factor_required ?? false);

        $needs2fa = $requireAll || $userRequired;

        // If needs 2fa but not confirmed, and not already on two-factor routes, redirect
        $hasConfirmed2fa = $user->two_factor_enabled && !empty($user->two_factor_confirmed_at);

        if ($needs2fa && ! $hasConfirmed2fa) {
            // allow the two-factor page and logout routes
            if ($request->routeIs('two-factor') || $request->routeIs('aluno.profile.*') || $request->is('user/two-factor-authentication*')) {
                return $next($request);
            }

            return redirect()->route('two-factor');
        }

        return $next($request);
    }
}
