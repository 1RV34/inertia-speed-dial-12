<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthenticatePlex
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $requestToken = $request->query('token');

        abort_if(! is_string($requestToken) || $requestToken === '', 401);

        $user = User::query()->where('plex_token', $requestToken)->first();

        abort_unless($user, 401);

        Auth::setUser($user);

        return $next($request);
    }
}
