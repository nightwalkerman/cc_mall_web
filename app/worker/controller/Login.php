<?php


namespace app\worker\controller;


use app\utils\tools\R;
use think\facade\View;
use app\manager\model\Admin as AdminModel;

class Login
{
    public function index()
    {
        return View::fetch();
    }

    public function login()
    {
        $postData = request()->getInput();
        $postData = json_decode($postData,true);
        if(!captcha_check($postData['captcha']))
        {
            return R::json(402, lang("captcha_error"),"");
        }

        $where['username'] = $postData['username'];
        $row = AdminModel::where($where)->withJoin(['role' => ['action_code','menu_code','read_write']])->find();

        // 判断数据是否存在
        if(!$row) return R::json(400,lang('username_not_exist'),'');

        // 判断密码是否正确
        if(!password_verify($postData['password'],$row['password'])) return R::json(401,lang('username_or_password_error'),'');

        // 将登陆信息记录到 session、redis等
        $adminSession = array(
            "admin_id"   => $row['admin_id'],
            "username"   => $row['username'],
            "role"       => $row['role']['action_code'],
            "menu"       => $row['role']['menu_code'],
            "read_write" => $row['role']['read_write'],
        );
        session('adminSession',$adminSession);

        // 登陆成功返回
        return R::json(0,lang('login_success'),'');
    }

    public function logout()
    {
        session(null);
        return redirect("/manager/login");
    }
}