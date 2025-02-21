<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if ($request->headers->get('role') !== $role) {
            return response()->json(["message" => "Access Denied"], 403);
        }

        return $next($request);
    }
}
