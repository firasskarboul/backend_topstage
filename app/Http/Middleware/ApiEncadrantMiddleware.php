<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class ApiEncadrantMiddleware
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

     //   if(Auth::check())
     //   {
     //        if(auth()->user()->tokenCan('server:encadrant')) 
     //        {
               
     //             return $next($request);
     //        }
     //        // else {
     //        //     return response()->json([
                  
     //        //         // 'message'=>'Access Denied ! you are not Encadrant',
                  
     //        //   ],403);
     //        // }


     //        else{
     //          abort(403);
     //        }
     //   }
         

    }
}
