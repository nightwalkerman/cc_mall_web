<?php
/**
 * http请求类， curlpost,file_get_contents请求封装
 */

namespace app\utils\http;

class Http 
{
    /**
     * php curl post 发送数据
     * @param type $url      网址
     * @param type $params   发送参数，格式为数组
     * @param type $timeOut  超时时间，单位秒
     * @return data          接收发送请求返回
     */
    static public function curlPost($url, $params = [] , $timeOut = 5) 
    {
        if (empty($url) || empty($params)) 
        {
           return false;
        }

        $o = "";
        foreach ( $params as $k => $v ) 
        { 
            $o.= "$k=" . urlencode($v). "&" ;
        }
        $params = substr($o,0,-1);

        $postUrl   = $url;
        $curlPost  = $params;
        $ch        = curl_init();                        //初始化curl
        curl_setopt($ch, CURLOPT_URL,$postUrl);          //抓取指定网页
        curl_setopt($ch, CURLOPT_HEADER, 0);             //设置header
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);     //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);     //设置超时时间为5秒，如果需要设置毫秒，则：CURLOPT_TIMEOUT_MS
        curl_setopt($ch, CURLOPT_POST, 1);               //post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
        $data      = curl_exec($ch);                     //运行curl
        curl_close($ch);

        return $data;
    }
    
    /**
     * php curl post 方式发送json格式的数据
     * @param type $url       连接地址
     * @param type $jsonData  json格式的数据
     * @param type $timeOut   超时时间，单位秒
     * @return data           接收请求返回数据
     */
    static function curlPostJson($url, $jsonData, $timeOut = 5)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeOut);            //设置超时时间为5秒，如果需要设置毫秒，则：CURLOPT_TIMEOUT_MS
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            "Content-Type: application/json; charset=utf-8",
            "Content-Length: " . strlen($jsonData))
        );
        ob_start();
        curl_exec($ch);
        $return_content = ob_get_contents();
        ob_end_clean();
        return $return_content;
    }
    
    /**
     * php file_get_contents get 方式发送数据
     * @param type $url          网址
     * @param type $timeOut      超时时间，单位秒
     * @return data              返回请求数据
     */
    static function fileGetContents($url, $timeOut = 5) 
    {
        $context = stream_context_create(array(
            'http' => array(
                'timeout' => $timeOut, //超时时间，单位为秒
            ) 
        ));  
        return file_get_contents($url, 0, $context);
    }
    
}
