<?php
  
namespace App\Http\Middleware;
  
use Closure;
use Illuminate\Http\Request;
use Auth;
use Cache;
use App\User;
  
class UserActivity
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $expiresAt = now()->addMinutes(2); /* already given time here we already set 2 min. */
            Cache::put('user-is-online-' . Auth::user()->id, true, $expiresAt);
            User::where('id', Auth::user()->id)->update(['last_seen' => now()]);
            /* user last seen */
           // $new_sessid   = \Session::getId(); 
           // $lt =  User::where('id', Auth::user()->id)->first();
           // if($lt->lastsession)
           // {
           //     
            //}
            //else
           // {
              //  User::where('id', Auth::user()->id)->update(['lastsession' => $new_sessid]);
           // }

          

        }
  
        return $next($request);
    }
}