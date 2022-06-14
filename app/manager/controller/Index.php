<?php


namespace app\manager\controller;

use think\facade\View;
use app\manager\model\Node as NodeModel;
use app\manager\model\Admin as AdminModel;
use app\manager\model\Config as ConfigModel;

class Index
{
    /*
     * 首页模块
     */
    public function index()
    {
        $adminSession = session("adminSession");
        View::assign("admin",$adminSession['username']);
        
        $config = new ConfigModel();
        View::assign("config", $config->getConfig());
        
        return View::fetch();
    }

    public function layuiTree()
    {
        $adminSession = session("adminSession");
        $node = new NodeModel();
        
        $config = new ConfigModel();

        $menu = $node->getSessionListTree($adminSession['menu']);
        //组合 laytree 格式数据
        $layJson = array(
            "homeInfo" => array("title"=>lang('home'),"href"=>"/manager/home"),
            "logoInfo" => array("title"=>$config->getConfig()['name'],"image"=> "/static/plugins/layui/images/logo.png","href"=>""),
            "menuInfo" => $menu
        );

        return json($layJson);
    }

    public function home()
    {
        return View::fetch();
    }

    /**
     * 测试模块
     */
    public function test()
    {
        $row = AdminModel::withJoin(['role' => ['role_name','action_code'] ])->select();
        return json($row);
        //halt($row);
    }
}