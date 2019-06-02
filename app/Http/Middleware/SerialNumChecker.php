<?php

namespace App\Http\Middleware;

use Closure;

class SerialNumChecker
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

        if(isset($request->serial)) {
            $snumbers = array_map('trim', explode(PHP_EOL, $request->serial));
            $snumbers = array_combine(range(1, count($snumbers)), $snumbers);

            $request->merge([
                'serial' => $snumbers
            ]);
        }

        return $next($request);
    }
}
