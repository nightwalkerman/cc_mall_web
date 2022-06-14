<?php


namespace app\manager\model;

use think\Model;

class ArticleCategory extends Model
{

    /*
     * 根据条件返回具体列表
     * @param array $where  查询条件
     * @param $currentPage  当前页码
     * @param $limitRows    每页显示条数
     */
    public function ccList($where = [], $currentPage = 1, $limitRows = 10)
    {
        $total = $this->where($where)->count('category_id');
        $rows  = $this->where($where)->page($currentPage,$limitRows)->select();
        $data  = array(
            "page" => $currentPage,
            "limit"=> $limitRows,
            "total"=> $total,
            "items"=> $rows
        );
        //echo $this->getLastSql();
        return $data;
    }

    /*
     * 获取单条记录信息
     * @param $id  测试内容ID
     * @return     返回单条内容详情
     */
    public function ccOne($id)
    {
        $where['category_id'] = $id;
        return $this->where($where)->find();
    }

    /*
     * @param $id
     */
    public function ccDel($id)
    {
        $where['category_id'] = $id;
        $row = $this->where($where)->find();
        return $row->delete();
    }

    public function ccAdd($data)
    {
        return $this->insert($data);
    }

    public function ccEdit($data)
    {
        $where['category_id'] = $data['category_id'];
        $row = $this->where($where)->find();
        $row->category_name = $data['category_name'];
        $row->subname       = $data['subname'];
        $row->parent_id     = $data['parent_id'];
        $row->category_url  = $data['category_url'];
        $row->article_id    = $data['article_id'];
        return $row->save();
    }
}