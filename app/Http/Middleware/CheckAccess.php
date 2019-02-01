<?php

namespace App\Http\Middleware;

use App\General;
use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAccess
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
        $user = Auth::user();
        if(!$user)
            return redirect()->route('login');
        $currentUrl = preg_replace('/[0-9]+/', '', $request->getRequestUri());
        if($currentUrl == '/dashboard')
            return $next($request);
        $permForms = General::getUserPermittedForm($user);
        if(in_array($currentUrl,array_column($permForms->toArray(),'url')))
            return $next($request);
        else
            return redirect()->intended('/dashboard')->with('notification' ,'شما اجازه دسترسی به این صفحه را ندارید');

    }
}
