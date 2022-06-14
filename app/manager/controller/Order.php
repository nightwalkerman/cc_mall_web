<?php

namespace app\manager\controller;

use app\utils\tools\FindString;
use think\facade\View;
use app\manager\model\Order as OrderModel;
use app\utils\tools\R;
use app\utils\time\TimeQuery;

class Order
{
    private $model;

    public function __construct()
    {
        $this->model = new OrderModel();
    }

    public function indexList()
    {
        // 统一公共请求入口，接收json参数
        $postData = request()->getInput();
        $postData = json_decode($postData,true);

        //判断 ccOption ，看看是操作哪个方法
        if(isset($postData['ccOption']))
        {
            //判断读写权限
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
                case "updateOrder":
                    return $this->updateOrder($postData);
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
        $where = [];
        
        $postData['system_order']   && $where[] = ['system_order','=',$postData['system_order']];
        $postData['merchant_order'] && $where[] = ['merchant_order','=',$postData['merchant_order']];
        $postData['merchant_id']    && $where[] = ['merchant_id','=',$postData['merchant_id']];
        $postData['start_time']     && $where[] = ['add_time','>=',$postData['start_time']];
        $postData['end_time']       && $where[] = ['add_time','<=',$postData['end_time']];
        
        $list = $this->model->ccList($where,$postData['page'],$postData['limit']);
        return R::json(0, "", $list);

    }

    private function ccOne($postData)
    {
        $data = $this->model->ccOne($postData['order_id']);
        return R::json(0, "", $data);
    }

    private function updateOrder($postData)
    {        
        $order = new OrderModel();
        return $order->ccEdit($postData);
    }


}