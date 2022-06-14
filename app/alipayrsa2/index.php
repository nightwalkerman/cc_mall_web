<?php
header('Access-Control-Allow-Origin: *');
header('Content-type: text/plain');

require_once 'aop/AopClient.php';
require_once 'aop/request/AlipayTradeAppPayRequest.php';

// 获取支付金额
$amount='1';
//if($_SERVER['REQUEST_METHOD']=='POST'){
//    $amount=$_POST['total'];
//}else{
//    $amount=$_GET['total'];
//}

$total = floatval($amount);
if(!$total){
    $total = 1;
}

$aop = new AopClient;
$aop->gatewayUrl = "https://openapi.alipay.com/gateway.do";
$aop->appId = "2021003121659719";
$aop->rsaPrivateKey = 'MIIEvwIBADANBgkqhkiG9w0BAQEFAASCBKkwggSlAgEAAoIBAQCjLA5EdRxjasUFHNRemdJlFqYU6WUdR1yvpdK1+Cw8IrcKLGz0qkDj9pwcbIhwMchweFlL2zUoqmaciS8tRw/g1/lLeE7ITqezAezPn3ci3UDAtrCC2GqA30PII/ujMhgSv9miOsfwn53Bcp/5xeEQROtpu3Bq1iWMmDGoBkNfxPCbRfh5PkqllLJJgKAxHvKukzeHBcHMAsgU/KLp+0amZ6vWyqUfznMdxqIsJzoJgjcQDFgCQS27WZ7r+G5GvLSyHhZ5uSPOIi0Qg0B/9dJuFytKeC4ApORKXPc9Q/GJHptfXAxNF90ajM78hHbrzGNwAZHULE1JH6o2MtlmHAuZAgMBAAECggEAf6pcj1tBltdWxyVDU7DuWIFb+EiUAFBxSExpjE5b7cELjT4tEVCT7MhqZCLWrVGGDdlbpGoiMWsBVcBP1REgbz8LoezDVx2TQA9lhRyzTefmXeGSQQ2qZqJImjLtE0aCZ0kLsk5jWPTJrS1N1VLpQJ1rwxIQZsaeIl6Bm4Eq/aYK5YMcFFOno9sc0YJ5i3tW3X0BdX3jqCciBR3W4OuG5aDh1twra+dTyQqfsWfZlexYTFH491+QU42pF3LDTKpAHdp0c4iOaUOvQQuGW4nAD0W+pzbySCOwRHd/C5aPTU89stkL8+TzAdGrSSKHciw1FGSVzB8Araeh3CZ/8Y7GAQKBgQDlBadr+h8MWTrl8yszCILsZoGSEIgwijKkbpZdyssctT7MRcYjTAWTk5eFak+BOX7eB8Vfw3QOyo3AAoXHgfuPUHK7Pqgz+QXtOhyI5AjyotB0aND7GndrCzoUJHXGQ45m/9ABGm5MuSUSjGPSe67F+mIL1QrAIZgsR2DN1hLXEQKBgQC2ZKRaLJDf9fH9KWJKwolcSiqdUowPZk4PvQGzBl95emrCF22Ua1iPvIRsChPlzAJl6O6xvkT254pI7dJ0mxvJngHGzRWZprqNQkmGBwF8UQxzhEOE8SGrSqPwH0SJ86wRdGHkbkT1dOSV0kC2OmCPN7Trs70tJ1P4iDDnZWK8CQKBgQDODIczw4Y5ovI1vtDoCklYjWUX2B3fpgaoIALTAcg53OtR95irWxNNUiWp2BsNxX/aHR276eq6AA0Gan6YH98Hcra2tkm48NwfMgBIPPm76zYm9cLHmGlGeoRXaPI5XcB59L/crj38czridEK/NZ3p6zpZMOSKNe9mLxXuOyMaMQKBgQCD62z4D63FXtTk347JNcU17CrAWRkWdk9VkMXu31gku8cFlP5bz/xhEd/RaMSVe6XsYbpq8oxc7IEXWHPUhO9nNxJf4KuT04SwcNZOyzhm2xQfZPWU7PcGNlk2btca1BSLF1tKZfsYcbB3MHg/lR+L1qXTqM/WHdDdPFvqsWjlSQKBgQDFhXgqWW6n8CdAoAn7q40OgQZiIkQcDH8KAHI5VdXX0mv+NX6AVMGcpkLQ/RvR5fgPsxK12OLFShZw0znNm5X6xd6+WhWtwF1D/FNPXSlrw6NpGFDgxO0hV9Z0rlkKEP0QzrOWvP0OP+00c2NGQWaG34f7elzWgr8b0LGrzBMDoA==';
$aop->format = "json";
$aop->charset = "UTF-8";
$aop->signType = "RSA2";
$aop->alipayrsaPublicKey = 'MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAgFORKfJKVeouzhPGt+Egt2u4Ct2ZdcmH2teJd8NGKyN2vEKQmICtz3KSdrJjL+FbhdQqZM+ABcauDalOMhpBZ30b8oXRQyMJunnjZmb5jTcvli2gt9VTi5PkEfTIyhiQwdLHmqc43/fu7huBsT0f+PYdu7TWeCSKJ5lGptzK9pSu4TAHsxZEGY+5R3IfRkE8IIz5j/0jZneS27LDlGRI6yjgdUj8slvKepabdwBqHK2mLBxC6cNjPaFoayoJK2slsDJT3Oibl+CM/73dkusryq+M/WcY44iSbYDLDtuaSe7V/5VqnfAR+Lu2gV9LPTMKnlvFa5dK2dPUCqqAEj8yrwIDAQAB';
//实例化具体API对应的request类,类名称和接口名称对应,当前调用接口名称：alipay.trade.app.pay
$request = new AlipayTradeAppPayRequest();

// 异步通知地址
$notify_url = urlencode('http://139.196.43.219:65000/api/notify');
// 订单标题
$subject = 'test';
// 订单详情
$body = 'testbody'; 
// 订单号，示例代码使用时间值作为唯一的订单ID号
$out_trade_no = date('YmdHis', time());

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
echo $response;
?>