<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class ProductEditorMiddleware
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
        // if ($request->user() && $request->user()->title != 'ProductEditor')
        // {
        //     return new Response(view('unauthorized')->with('role', 'ProductEditor'));
        // }
        // return $next($request);

        if ($request->user() && ($request->user()->title == 'ProductEditor' || $request->user()->title == 'Administrator') )
        {
            return $next($request);       
        }
        return new Response(view('admin.unauthorized')->with('role', 'ProductEditor or Administrator'));
        
    }
}
