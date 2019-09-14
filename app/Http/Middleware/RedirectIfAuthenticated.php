<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            $user = auth()->user();
            $accessToken = $this->createAccessToken($user);
            \Session::put('accessToken',$accessToken);
            \Session::save();
            
            return redirect('/home');
        }

        return $next($request);
    }

    /**
     * Create auth user access token
     * @param  Object $user
     * @return Token
     */
    public function createAccessToken($user = null)
    {
        $user = $user ?: auth()->user();
        $this->deleteAccessToken();
        return (!empty($user)) ? $user->createToken($user->name)->accessToken : false;
    }

    /**
     * Delete exists auth user access token
     * @return Boolean
     */
    public function deleteAccessToken()
    {
        return \DB::table('oauth_access_tokens')->where('user_id', optional(auth()->user())->id)->delete();
    }
}
