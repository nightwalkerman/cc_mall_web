<?php


namespace app\manager\controller;

use app\utils\tools\FindString;
use think\facade\View;
use app\manager\model\ArticleList as ArticleModel;
use app\utils\tools\R;
use app\utils\suning\SuningGoods;

class Articlelist
{
    private $model;

    public function __construct()
    {
        $this->model = new ArticleModel();
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

            //dump($postData);
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
                case "suning":
                    return $this->getSuning($postData);
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
            ['title','like','%'.$postData['title'].'%']
        ];
        $list = $this->model->ccList($where,$postData['page'],$postData['limit']);
        return R::json(0, "", $list);

    }

    private function ccOne($postData)
    {
        $data = $this->model->ccOne($postData['article_id']);
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
        //return dump($postData);
        $this->model->ccEdit($postData);
        return R::json(0, "", lang('operation_success'));
    }

    private function ccDel($postData)
    {
        $data = $this->model->ccDel($postData['article_id']);
        return R::json(0, "", lang('operation_success'));
    }
    
    private function getSuning($postData)
    {
        $data = SuningGoods::getDetails($postData['collection_url']);
        return R::json(0, "", $data);
    }
    
    public function addView()
    {
        return View::fetch();
    }
    public function addY()
    {
        $postData = input("request.");
        return $this->ccAdd($postData);
    }

    public function editView()
    {
        $article_id = input("id");
        $data = $this->model->ccOne($article_id);
        View::assign("article",$data);
        
        return View::fetch();
    }   
    public function editY()
    {
        $postData = input("request.");
        return $this->ccEdit($postData);
    }
    
}