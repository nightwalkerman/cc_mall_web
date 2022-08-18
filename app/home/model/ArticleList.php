<?php

namespace app\home\model;
use think\Model;

class ArticleList extends Model
{
 
    /*
     * 获取单条记录信息
     * @param $id  测试内容ID
     * @return     返回单条内容详情
     */
    public function ccOne($id)
    {
        $where['article_id'] = $id;
        return $this->where($where)->find();
    }
    
 
}
