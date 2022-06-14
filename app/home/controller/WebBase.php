<?php

namespace app\home\controller;
use app\home\model\ArticleCategory as CategoryModel;
use app\home\model\Config as ConfigModel;
use think\facade\View;

class WebBase 
{
    public function getMenu()
    {
        $category = new CategoryModel();
        $menu = $category->topMenu();
        View::assign("menu",$menu);
    }
    
    public function getConfig()
    {
        $config = new ConfigModel();
        View::assign("config", $config->getConfig());
    }
    
}
