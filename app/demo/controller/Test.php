<?php

namespace app\demo\controller;
use QL\QueryList;
use app\utils\tools\R;
use app\utils\http\Http;
use app\home\model\Config as ConfigModel;
use app\utils\suning\SuningGoods;

class Test 
{
    public function caiji()
    {
        $data = SuningGoods::getDetails("https://product.suning.com/0030000433/11887520913.html");
        dump($data);
        /*
        $txt = QueryList::get("https://product.suning.com/0071475907/608359901.html?adtype=1");
        
        // 标题
        echo $txt->find("li.line")->html();
        
        // 产品小图+大图
        $small = $txt->find(".imgzoom-thumb .imgzoom-thumb-main")->find("img")->attrs("src");
        $big   = $txt->find(".imgzoom-thumb .imgzoom-thumb-main")->find("img")->attrs("src-large");
        
        // 说明
        $imgs2 = $txt->find("#productDetail")->find("img")->attrs("src2");
        $imgs1 = $txt->find("#productDetail")->find("img")->attrs("src");
        $arrs = [];
        foreach($imgs1 as $img)
        {
            if($img)
            {
                array_push($arrs,$img);
            }            
        }
        foreach($imgs2 as $img)
        {
            if($img)
            {
                array_push($arrs,$img);
            }            
        }
        */
        
        //halt($price);
        //halt(R::toJsonSource($arrs));
        //halt(R::toJsonSource($small));
        //halt(R::toJsonSource($big));
        //halt($arrs);
        
    }
    
    public function testNotify() 
    {
//        $json = '{"gmt_create":"2022-02-24 08:37:12","charset":"UTF-8","seller_email":"moguoshangmao@hotmail.com","subject":"充值","sign":"IrdJpRh9FnrTjoaq+djKAzFOQKbsiI/foNy3PEu5PWAhVCketFj8kfmC+2VUcihtGcnYhLjR1LYVeSZ39dSxMchziNuhEDkVoLnnRI3HEggeo0L5mOLjljyZ4CNrapxjWVV0foMWu30lmjWXcaIy7VV1jyPVnk244r1t/NvqvYlxC5ZMK4rarOUMAngICvLPuY1zKRI0tflA5c7q5VqN5rYXjU/pztHNEgxjPfuJRYyUK1C2sTBjJHhGlE3ml3OZDNhU5zjPFrAFDg07SnwnyZmYX3RLMMd4//J8eC1D8Z0cE05ZgA1KNV/c0qyp3lpzkTobpZ/XB58/BGSfaJ0YMw==","body":"订单","buyer_id":"2088832368889472","invoice_amount":"0.01","notify_id":"2022022400222083713089471457894224","fund_bill_list":"[{\"amount\":\"0.01\",\"fundChannel\":\"ALIPAYACCOUNT\"}]","notify_type":"trade_status_sync","trade_status":"TRADE_SUCCESS","receipt_amount":"0.01","app_id":"2021003121659719","buyer_pay_amount":"0.01","sign_type":"RSA2","seller_id":"2088341777652222","gmt_payment":"2022-02-24 08:37:12","notify_time":"2022-02-24 08:51:37","version":"1.0","out_trade_no":"20220223234400286","total_amount":"0.01","trade_no":"2022022422001489471443173745","auth_app_id":"2021003121659719","buyer_logon_id":"zou***@163.com","point_amount":"0.00"}';
//        $json = json_decode($json,true);
//        $str = Http::curlPost("http://139.196.43.219:65000/api/notify", $json);
//        echo $str;
        $configModel = new ConfigModel();
        $config = $configModel->getConfig();
        echo $config->name;
    }
    
}
