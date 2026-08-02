<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureOwner
{
    public function handle(Request $request, Closure $next): Response
    {
        if (blank(config('owner.password_hash'))) {
            abort(503, 'Owner access is not configured.');
        }

        if ($request->session()->get('owner_authenticated') === true) {
            return $next($request);
        }

        return redirect()
            ->guest(route('login'))
            ->with('flashmessage', 'Сначала войдите как владелец');
    }
}
