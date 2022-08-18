<?php


namespace app\manager\model;
use think\model\concern\SoftDelete;
use app\utils\tools\R;
use think\Model;

class ArticleList extends Model
{

    /*
     * 根据条件返回具体列表
     * @param array $where  查询条件
     * @param $currentPage  当前页码
     * @param $limitRows    每页显示条数
     */
    public function ccList($where = [], $currentPage = 1, $limitRows = 10)
    {
        $total = $this->where($where)->count('article_id');
        $rows  = $this->where($where)->page($currentPage,$limitRows)->order("article_id desc")->select();
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
        $where['article_id'] = $id;
        return $this->where($where)->find();
    }

    /*
     * @param $id
     */
    public function ccDel($id)
    {
        $where['article_id'] = $id;
        $row = $this->where($where)->find();
        return $row->delete();
    }

    public function ccAdd($data)
    {
//        $data['goods_image_small'] = R::toJsonSource($data['goods_image_small']);
//        $data['goods_image_big'] = R::toJsonSource($data['goods_image_big']);
//        $data['goods_desc'] = R::toJsonSource($data['goods_desc']);
        return $this->insert($data);
    }

    public function ccEdit($data)
    {
        $where['article_id'] = $data['article_id'];
        $row = $this->where($where)->find();
        $row->title = $data['title'];
        $row->desc  = $data['desc'];
        
        return $row->save();
    }
}