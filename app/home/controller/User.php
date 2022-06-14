<?php

namespace app\home\controller;
use think\facade\View;
use app\home\model\User as UserModel;
use app\utils\tools\R;

class User extends WebBase
{
    private $model;

    public function __construct()
    {
        $this->model = new UserModel();
    }
    
    public function index() 
    {
        // 统一公共请求入口，接收json参数
        $postData = request()->getInput();
        $postData = json_decode($postData,true);
        $this->getMenu();
        $this->getConfig();
        
        // 判断 ccOption ，看看是操作哪个方法
        if(isset($postData['ccOption']))
        {   
            // 判断调用方法
            switch ($postData['ccOption'])
            {
                case "list":
                    return $this->ccList($postData);
                    break;
                case "login":
                    return $this->ccLogin($postData);
                    break;
                case "logout":
                    return $this->ccLogout();
                    break;
                case "one":
                    return $this->ccOne($postData);
                    break;
                case "add":
                    return $this->ccAdd($postData);
                    break;
                case "edit":
                    return $this->ccEdit($postData);
                    break;
                case "del":
                    return $this->ccDel($postData);
                    break;
                default:
                    return View::fetch();
                    break;
            }
        }  
        
        $this->getMenu();
        return View::fetch();
    }
    
    private function ccList($postData)
    {
        if(!session('user')) return R::json (101,"请先登陆！");
        $where = [];
        $list = $this->model->ccList($where,$postData['page'],$postData['limit']);
        return R::json(0, lang('operation_success'), $list);

    }

    private function ccOne($postData)
    {
        $data = $this->model->ccOne(session("user.user_id"));
        return R::json(0, lang('operation_success'), $data);
    }

    private function ccAdd($postData)
    {
        if(!session('user')) return R::json (101,"请先登陆！");
        unset($postData['ccOption']);
        $this->model->ccAdd($postData);
        return R::json(0, "", lang('operation_success'));
    }

    private function ccEdit($postData)
    {
        $this->model->ccEdit($postData);
        return R::json(0,lang('operation_success'));
    }

    private function ccDel($postData)
    {
        $data = $this->model->ccDel($postData['cart_id']);
        return R::json(0,lang('operation_success'));
    }
    
    public function info()
    {
        $this->getMenu();
        $this->getConfig();
        return View::fetch();
    }
}
