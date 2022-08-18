<?php

namespace app\demo\controller;
use app\utils\http\Http;
class Jctest 
{
    public function index() 
    {
//        $context = stream_context_create(array(
//            'http' => array(
//             'timeout' => 5 //超时时间，单位为秒
//            ) 
//        ));  
//        file_get_contents("http://localhost:8000/demo/delay",0,$context);
//        $data = array(
//            "id" => "aaa"
//        );
//        $str = Http::fileGetContents("http://127.0.0.1:20001/demo/test/a");
//        return "aaa|".$str."|done";
        
        $this->t("aaa","bbb","ccc");
    }
    
    
    public function delay()
    {
        //sleep(10);
        return "aa";
    }
    
    public function t(...$agrs)
    {
        dump($agrs);
    }
    
}
