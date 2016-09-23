<?php

namespace App\Http\Middleware;


use Closure;
use App\Contact;


class UserRights
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
    $contact = $request->route()->parameter('contact');
    
    if ($contact->user_id != \Auth::user()->id)
    {
        abort(403, 'Access denied.');
    }

    return $next($request);
}
}
