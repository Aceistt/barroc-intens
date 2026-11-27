<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Laat alleen gebruikers met een van de opgegeven rollen door.
 *
 * Gebruik in routes: ->middleware('role:Sales,Maintenance')
 *
 * Let op: Admin krijgt hier bewust geen automatische toegang. Volgens het
 * interview mag de Admin alleen gebruikersaccounts beheren.
 */
class EnsureUserHasRole
{
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        $user = $request->user();

        if ($user === null) {
            return redirect()->guest(route('login'));
        }

        foreach ($roles as $role) {
            if ($user->hasRole($role)) {
                return $next($request);
            }
        }

        abort(403, 'Je hebt geen toegang tot deze pagina.');
    }
}
