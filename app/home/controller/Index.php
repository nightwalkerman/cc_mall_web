<?php

namespace app\home\controller;
use think\facade\View;
use app\home\model\Category as CategoryModel;
use app\home\model\Banner as BannerModel;

class Index extends WebBase
{
    public function index()
    {
        $this->getMenu(); // 导航菜单
        $this->getConfig();
        
        $category = new CategoryModel();
        View::assign("category", $category->getCategoryHomeGoods());
        
        $banner = new BannerModel();
        View::assign("banner", $banner->getBanner());
        
        return View::fetch();
        
    }
    
}
