<?php


namespace TLLibs\Middleware;


use TLLibs\Auth\TokenCenter;
use TLLibs\Models\User;
use \Closure;
class Authenticate
{
    public function handle($request, Closure $next, $guard = null)
    {
        $authKey = $request->header('auth-key',null);
        $token = TokenCenter::getInstance()->authToken($authKey);
        $user = User::where('token', $token)->first();
        if(empty($user)){
            abort(203);
        }
        $request->user = $user;
        return $next($request);
    }
}