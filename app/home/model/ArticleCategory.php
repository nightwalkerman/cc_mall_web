<?php

namespace app\home\model;
use think\Model;

class ArticleCategory extends Model
{
    public function goods()
    {
        return $this->hasMany(Goods::class,'category_id','category_id');
    }
    
    
    public function topMenu() 
    {
        $where['delete_status'] = "1";
        $where['parent_id'] = 0;
        return $this->where($where)->select();
    }
    
    /*
     * 首页分类及商品显示
     */
    public function getCategoryHomeGoods() 
    {
        $where['delete_status'] = "1";
        $this->goods()->limit(4);
        $rows = $this->where($where)->select();
        return $rows;
    }
    
    public function ccOne($id)
    {
        $where['category_id'] = $id;
        $rows = $this->where($where)->find();
        return $rows;
    }
}
