<?php

namespace app\manager\controller;

use think\facade\View;
use app\manager\model\Banner as BannerModel;
use app\utils\tools\R;
use app\utils\alioss\Oss;

class Banner
{
    private $model;

    public function __construct()
    {
        $this->model = new BannerModel();
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
                case "add":
                    return $this->ccAdd($postData);
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
        $where = [];
        $list = $this->model->ccList($where,$postData['page'],$postData['limit']);
        return R::json(0, "", $list);

    }


    private function ccAdd($postData)
    {
        unset($postData['ccOption']);
        $this->model->ccAdd($postData);
        return R::json(0, "", lang('operation_success'));
    }

    private function ccDel($postData)
    {
        $data = $this->model->ccDel($postData['banner_id']);
        return R::json(0, "", lang('operation_success'));
    }
    
    public function upload()
    {
        // 上传到本地服务器
        $file = request()->file('file');
        $savename = \think\facade\Filesystem::putFile( 'topic', $file);
        
        // 获取完整路径
        $url = runtime_path()."../storage/".$savename;
        
        //上传到阿里OSS
        $oss = new Oss();
        $ossName = $file->hashName();
        $ali = $oss->upload($ossName, $url);
        
        // 组合参数入库
        $data = [
            'image_url' => $ali['url'],
            'image_name'=> $ossName,
            'url'       => input('url')
        ];
        
        $this->model->ccAdd($data);
        @unlink($url);
    }
}
