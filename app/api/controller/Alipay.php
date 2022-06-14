<?php

namespace app\api\controller;
use app\alipayrsa2\aop\AopClient;
use app\alipayrsa2\aop\request\AlipayTradeAppPayRequest;
use app\utils\tools\R;
use app\home\model\Order as OrderModel;
use app\home\model\Config as ConfigModel;


class Alipay 
{
    public function pay() 
    {
        $postData = request()->getInput();       
        $postData = json_decode($postData,true);
        //halt($postData);
        
        // 获取订单，根据订单编号
        $orderModel = new OrderModel();
        $where['system_order'] = $postData['system_order'];
        $order = $orderModel->appOne($where);
        if(!$order) return R::json(1,"订单不存在");
        
        // 获取支付金额
        //$total = number_format($order['order_amount'],2,".","");
        $total = $order['order_amount'];
        //echo  $order['order_amount'];
        // 读取系统配置信息
        $configModel = new ConfigModel();
        $config = $configModel->getConfig();
        
        $aop = new AopClient();
        $aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
        $aop->appId = $config->alipay_appid;
        $aop->rsaPrivateKey = $config->private_key;
        $aop->format = "json";
        $aop->charset = "UTF-8";
        $aop->signType = "RSA2";
        $aop->alipayrsaPublicKey = $config->alipay_public_key;
        //实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
        $request = new AlipayTradeAppPayRequest();

        // 异步通知地址
        $notify_url = $config->notify_url;
        // 订单标题
        $subject = '充值';
        // 订单详情
        $body = '订单'; 
        // 订单号，示例代码使用时间值作为唯一的订单ID号
        $out_trade_no = $order['system_order'];

        //SDK已经封装掉了公共参数，这里只需要传入业务参数
        $bizcontent = "{\"body\":\"".$body."\","
                        . "\"subject\": \"".$subject."\","
                        . "\"out_trade_no\": \"".$out_trade_no."\","
                        . "\"timeout_express\": \"30m\","
                        . "\"total_amount\": \"".$total."\","
                        . "\"product_code\":\"QUICK_MSECURITY_PAY\""
                        . "}";
        $request->setNotifyUrl($notify_url);
        $request->setBizContent($bizcontent);
        //这里和普通的接口调用不同，使用的是sdkExecute
        $response = $aop->sdkExecute($request);

        // 注意：这里不需要使用htmlspecialchars进行转义，直接返回即可
        //echo $response;
        return R::json(0,'',$response);
    }
}


/*
 method=alipay.trade.app.pay&app_id=2015112700878442&charset=utf-8&version=1.0&sign_type=RSA2&timestamp=2022-02-23 16:37:06&notify_url=https://dcloud.net.cn/no-where-to-request&sign=ZtPTI8DXYxMqgWyR+ShuXXtViucmy1j98z6rL2tMaWLZ19YISKWzwzkxHFjItzr9EJubU25Cg2oaMT+G/rAIiHXWFkfX8MAjRJKbnFg0/p7WypAVv3rVFgYPRtFtDIIrhB7cqyNub8dd3vNcA9z2bbdVRnYIwTkAqXd6jLO6mOO23W7cHGZypl5B9MRyaMdkqxSLw1IEhiqcA4NJDaPKzAyr5osvzqxOqiIZCwfGffW6IS5TfmVLtk4P6dVyqKsSjVD/ov+vOifKpwq6iLyo+6NlGBv4LHP3DHrKLsUOc5+ItO8YQ0QcUIixp4EY3P550yi8OqvaMn8yxq/RAQXp7Q==&biz_content={"out_trade_no":"1645605426389","subject":"测试商城的测试订单标题","body":"测试商城的测试订单详情","total_amount":0.01}
 
 method=alipay.trade.app.pay&app_id=2021003121659719&charset=UTF-8&version=1.0&sign_type=RSA2&timestamp=2022-02-23 15:59:51&notify_url=http%3A%2F%2F139.196.43.219%3A65000%2Fapi%2Fnotify&sign=BeSNWBAvARacVS7mRGzytOOh7GCxnCA46a38j2nqB8wsh72Mv3NhZV4hRXAVXEvSTv9LWzywxw0Gsbd5dFaqwKd/oAgaRIsR1QTb2C4FnWUqtHP8mXfpQsGPpoqMIprCQL5hCx5FqqcnAAxxkEHu14BYEvtihM8R030SDHsP6sxsv1/X4It3rZYa4Ler4uIt5Az8qMO4tf2ecAWBiXQo/VmwmzoKhD+nNevRRQ8XIID6jwCY/lg1yJdL0GOf9aJQXi61khqJC0GHcwqhW52/s1k7ANDivDOCd4BN2mqBQ2rxTzQ3WaTgz4IarQeKi0cWQgogs/5LB20H0e3ia2h0iQ==&format=json&alipay_sdk=alipay-sdk-php-20161101&biz_content={"body":"订单","subject": "充值","out_trade_no": "20220223155951","timeout_express": "30m","total_amount": "1","product_code":"QUICK_MSECURITY_PAY"}
 * * 
 * 
 */