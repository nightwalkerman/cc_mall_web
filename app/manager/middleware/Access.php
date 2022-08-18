<?php


namespace app\manager\middleware;
use app\utils\tools\FindString;

class Access
{
    public function handle($request, \Closure $next)
    {
        $adminSession = session('adminSession');
        $pathUrl = $request->pathinfo();
        $method  = $request->method();

        // 判断如果没有session, 或者不是指定的页面，则重定向到登陆页面
        if(!$adminSession && !FindString::searchKeyword($pathUrl))
        {
            return redirect('/manager/asyncLogout');
        }

        // 如果已经登陆，则判断有没有对应的权限
        if($adminSession)
        {
            if($adminSession['role'] == "all")
            {

            }
            else
            {
                $roleArr = explode(',',$adminSession['role']);

                // 增加公共访问页面
                array_push($roleArr,"index","home","asyncLogout","menu","layuiTree");

                if(!FindString::searchKeyword($pathUrl,$roleArr))
                {
                    halt("权限不足");
                }

            }
        }

        return $next($request);
    }


}