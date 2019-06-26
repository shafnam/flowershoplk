<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;

class EditorMiddleware
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
        // if ($request->user() && $request->user()->title != 'Editor')
        // {
        //     return new Response(view('admin.unauthorized')->with('role', 'Editor'));
        // }
        // return $next($request); 
        if ($request->user() && ($request->user()->title == 'Editor' || $request->user()->title == 'Administrator') )
        {
            return $next($request);       
        }
        return new Response(view('admin.unauthorized')->with('role', 'Editor or Administrator'));
    }
}
