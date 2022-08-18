<?php


namespace app\manager\controller;
use app\utils\tools\FindString;
use app\utils\tools\R;
use think\facade\View;
use app\manager\model\Role as RoleModel;

class Role
{
    private $model;

    public function __construct()
    {
        $this->model = new RoleModel();
    }

    public function indexList()
    {
        // 统一公共请求入口，接收json参数
        $postData = request()->getInput();
        $postData = json_decode($postData,true);

        // 判断 ccOption ，看看是操作哪个方法
        if(isset($postData['ccOption']))
        {
            // 判断读写权限
            if(session('adminSession.read_write') == "1" && FindString::searchKeyword($postData['ccOption'],['edit','add','del']))
            {
                return R::json(403,"只读权限，禁止操作","");
            }

            // 判断调用方法
            switch ($postData['ccOption'])
            {
                case "list":
                    return $this->ccList($postData);
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

        return View::fetch();
    }


    private function ccList($postData)
    {
        $where = [
            ['role_name','like','%'.$postData['role_name'].'%']
        ];
        $list = $this->model->ccList($where,$postData['page'],$postData['limit']);
        return R::json(0, "", $list);

    }

    private function ccOne($postData)
    {
        $data = $this->model->ccOne($postData['role_id']);
        return R::json(0, "", $data);
    }

    private function ccAdd($postData)
    {
        unset($postData['ccOption']);
        $this->model->ccAdd($postData);
        return R::json(0, "", lang('operation_success'));
    }

    private function ccEdit($postData)
    {
        $this->model->ccEdit($postData);
        return R::json(0, "", lang('operation_success'));
    }

    private function ccDel($postData)
    {
        $data = $this->model->ccDel($postData['role_id']);
        return R::json(0, "", lang('operation_success'));
    }
}