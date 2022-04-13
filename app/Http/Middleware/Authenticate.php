<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;
use Session;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
		//if ( Auth::guard('web')->check() === 1 ){ return '/stock'; }
		//if ( Auth::guard('customer')->check() === 1 ){ return '/booking'; }
		//if ( !Auth::guard('web')->check() && !Auth::guard('customer')->check() ){ return '/login'; }
    }
	
}
