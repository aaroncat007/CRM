<?php

namespace App\Http\Middleware;

use Closure;
use Sentinel;
use Session;

class SentinelManageAccess
{  
 /**  
  * Handle an incoming request.  
  *  
  * @param \Illuminate\Http\Request $request  
  * @param \Closure $next  
  * @return mixed  
  */  
 public function handle($request, Closure $next)  
 {  
   // First make sure there is an active session  
   if (!Sentinel::check()) {  
     if ($request->ajax()) {  
       return response('Unauthorized.', 401);  
     } else {  
       return redirect()->guest(route('auth.login'));  
     }  
   }  
   // Now check to see if the current user has the 'Boss' permission  
   if (!Sentinel::getUser()->inRole('Admin') && !Sentinel::getUser()->inRole('SuperAdmin')) {  
     if ($request->ajax()) {  
       return response('Unauthorized.', 401);  
     } else {  
       Session::flash('error', trans('auth.user.noaccess'));  
       return redirect()->route('auth.login');  
     }  
   }  
   // All clear - we are good to move forward  
   return $next($request);  
 }  
}  