<?php
/**
 * 空控制器
 */
namespace app\home\controller;

class Error 
{
    public function __call($method, $args)
    {
        return 'error request!';
    }
}
