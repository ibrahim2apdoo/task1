<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckPassword
{

    public function handle(Request $request, Closure $next)
    {
        if ($request->api_password !==env('API_PASSWORD','jD4Dp2rMZiuwiz5MYW0Sr')){
            return response()->json(['message'=>'you are not Authenticated']);
        }
        return $next($request);
    }
}
