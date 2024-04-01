<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateWithBearerToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        $token = $request->bearerToken();

        if (!$token || $token != "agroDepot") {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // You can add additional logic here to validate the token (e.g., check it against the database).

        return $next($request);
    }
}
