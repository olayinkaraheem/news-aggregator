<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\Http\NewsAggregatorResponse;
use Symfony\Component\HttpFoundation\Response;

class CheckEmailIsVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if ($request->user() && !$request->user()->hasVerifiedEmail()) {
            return (new NewsAggregatorResponse(
                message: __('auth.email_not_verified')
            ))->asForbidden();
        }

        return $next($request);
    }
}
