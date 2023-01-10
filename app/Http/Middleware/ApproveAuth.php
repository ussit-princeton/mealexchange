<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\transaction;


class ApproveAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (!cas()->checkAuthentication()) {

            if ($request->ajax()) {
                return abort(401);
            }
            cas()->authenticate();
        }


        $transaction_no = $request->route()->parameters['approval'];

        $transaction = transaction::find($transaction_no);

        if($transaction->host_userid == cas()->user()) {
            session()->put('cas_user', cas()->user());
            return $next($request);
        }

        else {
            abort(403);
        }



        }

    }
