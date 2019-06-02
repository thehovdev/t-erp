<?php

namespace App\Http\Middleware;

use Closure;

class XSS_Protection
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
        $input = $request->all();
        array_walk_recursive($input, function(&$input) {
            if($input !== null) {
                $input = strip_tags($input);
                $input = trim($input);
            }

        });
        $request->merge($input);


        return $next($request);
    }
}
