<?php

namespace App\Http\Middleware;

use Closure;
use App\SitUser;
use Carbon\Carbon;
use App\SitUserActivity;

class CheckInUser
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
        // return $next($request);

        $sit_session = session()->get('sit_session');
        $sitUser = session()->get('sit_user');
        if(is_null($sit_session))
        {
            $sitUser = SitUser::where('users.id', $request->user_id)
            ->join('user_activities', function ($join) use ($request) {
                $join->on('users.id', '=', 'user_activities.user_id')
                    ->whereNotNull('user_activities.session_id')
                    ->where('user_activities.session_id', '=', $request->session_id);
            })->first();
          //  dd($request->all(),1); // esto siempre da falso  y nunca encuentra la session
            if(!is_null($sitUser))
            {
                if(Carbon::parse($sitUser->last_login)->format('Y-m-d') === Carbon::now()->format('Y-m-d'))
                {
                    session(['sit_session' => $sitUser->session_id]);
                    session(['sit_user' => $sitUser]);
                    session()->save();

                    return $next($request);
                }else{
                    return redirect('https://sit.ips.com.ar');
                }
            }else{
                return redirect('https://sit.ips.com.ar');
            }
        }
        // dd($sit_session);

        if(!is_null($sit_session) && !is_null($sitUser))
        {
            // check if logged out in sit
            $userActivity = SitUserActivity::select('session_id')->where('user_id', $sitUser->user_id)->first();
            if(is_null($userActivity->session_id) || $userActivity->session_id !== $sit_session)
            {
                session()->forget('sit_session');
                session()->forget('sit_user');
                return redirect('https://sit.ips.com.ar');
            }
            return $next($request);
        }
        return redirect('https://sit.ips.com.ar');
    }
}
