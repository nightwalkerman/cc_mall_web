<?php


namespace app\home\middleware;

class Access
{
    public function handle($request, \Closure $next)
    {
        $user = session('user');
        // 判断如果没有session, 或者不是指定的页面，则重定向到登陆页面
        if(!$user)
        {
            return redirect('/home/signin');
        }
        
        return $next($request);
    }

}