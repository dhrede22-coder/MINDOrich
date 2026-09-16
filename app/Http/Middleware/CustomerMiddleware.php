<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        if (
            auth()->check() &&
            auth()->user()->role &&
            auth()->user()->role->name === 'Customer'
        ) {
            return $next($request);
        }

        abort(403, 'Unauthorized Access.');
    }
}