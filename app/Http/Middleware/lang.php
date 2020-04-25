<?php

namespace App\Http\Middleware;

use Closure;
use App;
use Illuminate\Support\Facades\App as FacadesApp;

class lang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $lang = 'vi';
        if (session('ngon-ngu')) {
            $lang = session('ngon-ngu');
        }
        FacadesApp::setlocale($lang);

        return $next($request);
    }
}
