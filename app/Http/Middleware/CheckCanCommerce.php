<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckCanCommerce
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check() || !Auth::user()->canCormmerce) {
            return redirect()->route('main')
                ->with('error', "Vous n'avez pas l'autorisation d'acceder a l'espace artisan. Contactez un administrateur.");
        }
        return $next($request);
    }
}
