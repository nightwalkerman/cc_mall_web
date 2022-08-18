<?php
/**
 *  YYinfinite pay
 */
namespace app\api\controller;
use app\home\model\Config as ConfigModel;
use app\home\model\Order as OrderModel;

class Ypay 
{
    public function index() 
    {
        $configModel = new ConfigModel();
        $config = $configModel->getConfig();
        
        $where['system_order'] = input("id");
        $orderModel = new OrderModel();
        $order = $orderModel->appOne($where);
        if(!$order)
        {
            return "订单不存在";
        }
        
        $systemData = array(
            'app_id'            => $config->yyid,
            'order_sn'          => $order->system_order,
            'order_amount'      => $order->order_amount,
            'bank_code'         => 'yfb_ALIPAY',
            'notify_url'        => $this->localHostDomain()."api/ypayNotify",
        );

        $signature = $this->signatureToMD5($systemData, $config->yykey);
        
        $url = $config->yyurl."?". $this->arrayToUrlData($systemData) ."signature=".$signature;
        //dump($url);
        echo "支付操作中，请稍后。。。";
        return redirect($url);
        
    }
    
    public function notify() 
    {
        //接上参数
        $parameter = input("request.");        
        unset($parameter['signature']);
        
        //读取订单
        $orderModel = new OrderModel();        
        $whereOrder['system_order'] = $parameter['order_sn'];
        $whereOrder['order_amount'] = $parameter['order_amount'];
        $order = $orderModel->appOne($whereOrder);
        
        if(!$order)
        {
            return "订单不存在";
        }
        
        if($order->pay_status == "支付成功")
        {
            return "success";
        }
        
        //只有状态为4,未支付的订单,才能执行回调通知。其它状态不能处理
        if($order->pay_status != "等待支付")
        {
            return 'Error Status';
        }
        
        //验证签名
        $configModel = new ConfigModel();
        $config = $configModel->getConfig();
          
        $postSignature = input('signature');
        $thisSignature = $this->signatureToMD5($parameter, $config->yykey);
        if(strtoupper($postSignature) != strtoupper($thisSignature))
        {
            return "signature error: ".$postSignature." | ".$thisSignature;
        }
        ///////////
        
        //判断支付状态
        if ($parameter['pay_status'] != "1")
        {
            return "pay status error";
        }
               
        if($order) 
        {

            //处理更新订单,新增资金记录
            $order->pay_status = "1";
            $order->order_status = "2";
            $order->save();
            
            //输出结果,返回给三方
            echo "success";
            
            
            
        }
    }
    
    /*  md5 签名
    *  按 a - z 排序
    *  sort()   - 以升序对数组排序
       rsort()  - 以降序对数组排序
       asort()  - 根据值，以升序对关联数组进行排序
       ksort()  - 根据键，以升序对关联数组进行排序
       arsort() - 根据值，以降序对关联数组进行排序
       krsort() - 根据键，以降序对关联数组进行排序
    *  
    */
    private function signatureToMD5($parameter,$code)
    {

       ksort($parameter);                          //a-z 排序       
       $klength = count($parameter);               //统计长度

       $encode_str = "";
       foreach ($parameter as $key => $val)
       {
           if($val){
               if($val != "null"){  
                   $encode_str .= $key."=".$val."&";
               }
           }
       }
       $encode_str .= $code;

       return strtoupper(md5($encode_str));   

    }
    
    //返回当前域名
    public function localHostDomain()
    {
        $http_type = $this->isSSL();
        $http_host = $_SERVER['HTTP_HOST'];
        return $http_type.$http_host."/";
    }
    
    public function isSSL()
    {
        $http_type = ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] == 'https')) ? 'https://' : 'http://';
        return $http_type;
    }
    
    //将数组数据转换为浏览器数据
    public function arrayToUrlData($parameter)
    {
       ksort($parameter);                          //a-z 排序       
       $klength = count($parameter);               //统计长度
       $encode_str = "";
       foreach ($parameter as $key => $val)
       {
            $encode_str .= $key."=".$val."&";
       }
       return $encode_str;
    }
    
}
