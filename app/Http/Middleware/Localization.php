<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $locale = $request->hasHeader('lang');

        if (!in_array($locale = $request->header('lang'), ['en', 'ar', 'ru'])) {
            $locale = 'en';
        }

        app()->setLocale($locale);
        return $next($request);
    }
}
