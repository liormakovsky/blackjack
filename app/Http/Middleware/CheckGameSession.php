<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckGameSession
{
    /**
     * Handle an incoming request.
     *
     * Check game session and redirect to begin if it is invalid.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $game = session('game');

        if (!$game) {
            session()->now('status', 'The game session is expired. Prepare to new game');
            return redirect(route('blackjack.index'));
        }
        return $next($request);
    }
}
