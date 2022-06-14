<?php
/**
 * 统一返回 json 结果集类
 */

namespace app\utils\tools;


class R
{
    /**
     * @param int $code        错误码
     * @param string $message  信息提示
     * @param string $data     返回数据
     * @return false|string    返回json字符串
     */
    static public function json($code = 0, $message = '', $data = '')
    {
        $data = array(
            "code"    => $code,
            "message" => $message,
            "data"    => $data
        );
        return json($data);
    }
    
    // 转Json 原样显示，中文不转义，不带 \ 符号
    static public function toJsonSource($source) 
    {
        return json_encode($source,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
    }
    
    // 生成订单编号
    static public function orderSn() 
    {
        $mtimestamp = sprintf("%.3f", microtime(true)); // 带毫秒的时间戳
        $timestamp = floor($mtimestamp); // 时间戳
        $milliseconds = round(($mtimestamp - $timestamp) * 1000); // 毫秒
        return date("YmdHis", $timestamp).$milliseconds;
    }
}