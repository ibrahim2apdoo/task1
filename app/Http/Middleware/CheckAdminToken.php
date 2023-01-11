<?php

namespace App\Http\Middleware;

use App\Http\Controllers\Api\GeneralApiTrait;
use Closure;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Facades\JWTAuth;

class CheckAdminToken
{
    use GeneralApiTrait;
    public function handle(Request $request, Closure $next)
    {
        $user = null;
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (\Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->returnError('3001','INVALID_TOKEN');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this->returnError('3001','EXPIRED_TOKEN');

            } else {
                return $this->returnError('3001','TOKEN_NOTFOUND');

            }
        } catch (\Throwable $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->returnError('3001','INVALID_TOKEN');

            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this->returnError('3001','EXPIRED_TOKEN');

            } else {
                return $this->returnError('3001','TOKEN_NOTFOUND');

            }
        }

        if (!$user)
            return $this->returnError('3001','Unauthenticated');

        // return $this->returnError('E331', trans('Unauthenticated'));
        return $next($request);
    }
}
