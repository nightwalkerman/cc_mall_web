<?php


namespace app\manager\model;
use think\model\concern\SoftDelete;
use app\utils\tools\R;
use think\Model;

class Goods extends Model
{

    /*
     * 根据条件返回具体列表
     * @param array $where  查询条件
     * @param $currentPage  当前页码
     * @param $limitRows    每页显示条数
     */
    public function ccList($where = [], $currentPage = 1, $limitRows = 10)
    {
        $total = $this->where($where)->count('goods_id');
        $rows  = $this->where($where)->page($currentPage,$limitRows)->order("goods_id desc")->select();
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
        $where['goods_id'] = $id;
        return $this->where($where)->find();
    }

    /*
     * @param $id
     */
    public function ccDel($id)
    {
        $where['goods_id'] = $id;
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
        $where['goods_id'] = $data['goods_id'];
        $row = $this->where($where)->find();
        $row->goods_name        = $data['goods_name'];
        $row->goods_image_small = $data['goods_image_small'];
        $row->goods_image_big   = $data['goods_image_big'];
        $row->goods_number      = $data['goods_number'];
        $row->goods_desc        = $data['goods_desc'];
        $row->goods_price       = $data['goods_price'];
        $row->goods_number      = $data['goods_number'];
        $row->collection_url    = $data['collection_url'];
        $row->category_id       = $data['category_id'];
        $row->color             = $data['color'];
        $row->version           = $data['version'];
        return $row->save();
    }
}