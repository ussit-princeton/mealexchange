<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CasAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     *
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()){
            if (! cas()->checkAuthentication()) {

                if ($request->ajax()) {
                    return abort(401);
                }
                cas()->authenticate();
            }

            $user= User::where('userid',cas()->user())->first();

            if(!$user) {
                return abort(401);
            }

            Auth::login($user, true);

            session()->put('cas_user', cas()->user());
        }

        return $next($request);
    }
}
