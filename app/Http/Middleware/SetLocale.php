<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Carbon\Carbon;

class SetLocale
{
    public function handle(Request $request, Closure $next)
    {
        $available = ['en', 'fr', 'es'];

        // Priority: explicit session choice > app default (en)
        $locale = $request->session()->get('locale', config('app.locale'));

        if (! in_array($locale, $available)) {
            $locale = config('app.locale');
        }

        App::setLocale($locale);
        Carbon::setLocale($locale);

        $response = $next($request);

        // Expire any old locale_explicit cookie left by previous sessions
        if ($request->cookie('locale_explicit')) {
            $response->withCookie(cookie()->forget('locale_explicit'));
        }

        return $response;
    }
}
