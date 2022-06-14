<?php

namespace app\home\model;
use think\Model;

class OrderGoods extends Model
{
    public function getGoodsImageBigAttr($value)
    {
        return json_decode($value);
    }
    
    public function getGoodsImageSmallAttr($value)
    {
        return json_decode($value);
    }
    
    public function getGoodsDescAttr($value)
    {
        return json_decode($value);
    }
}
