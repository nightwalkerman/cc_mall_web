<?php

namespace app\home\controller;
use think\facade\View;
use app\home\model\ArticleCategory;
use app\home\model\ArticleList;

class Category extends WebBase
{
    public function index() 
    {
        $this->getMenu(); //显示菜单导航
        $this->getConfig();
        
        $categoryModel = new ArticleCategory();
        $category = $categoryModel->ccOne(input("id"));
        $subname  = explode("|", $category['subname']);
        $articleModel = new ArticleList();
        $article = $articleModel->ccOne($category['article_id']);
        View::assign("subname",$subname);
        View::assign("category",$category);
        View::assign("article",$article);
        return View::fetch();
    }
}
