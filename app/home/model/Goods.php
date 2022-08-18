<?php

namespace app\home\model;
use think\Model;

class Goods extends Model
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
    
    public function getColorAttr($value)
    {
        return json_decode($value);
    }
    
    public function getVersionAttr($value)
    {
        return json_decode($value);
    }
    
    public function getCategoryGoods($category_id) 
    {
        $where['category_id'] = $category_id;
        $rows = $this->where($where)->select();       
        return $rows;
    }
    
    public function getGoodsDetail($goods_id)
    {
        $where['goods_id'] = $goods_id;
        $row = $this->where($where)->find();
        return $row;
    }
    
    /*
     * 获取单条记录信息
     * @param $id  测试内容ID
     * @return     返回单条内容详情
     */
    public function ccOne($id)
    {
        $where['goods_id'] = $id;
        return $this->where($where)->find();
    }
    
    public function hotGoods()
    {
        return $this->limit(6)->select();
    }
    public function killGoods()
    {
        return $this->order("goods_id desc")->limit(6)->select();
    }
    
    public function goodsList($index, $where = [], $limit = 10)
    {
        $rows = $this->where($where)->page($index,$limit)->select();
        return $rows;
    }
    
}
