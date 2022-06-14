<?php

namespace app\home\controller;
use think\facade\View;
use app\home\model\Goods as GoodsModel;

class Goods extends WebBase
{
    public function index() 
    {
        $this->getMenu(); 
        $this->getConfig();
        $goods = new GoodsModel();
        View::assign("goods",$goods->getGoodsDetail(input("id")));
        return View::fetch();
    }
}
