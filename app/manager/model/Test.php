<?php


namespace app\manager\model;
use think\model\concern\SoftDelete;

use think\Model;

class Test extends Model
{

    /*
     * 根据条件返回具体列表
     * @param array $where  查询条件
     * @param $currentPage  当前页码
     * @param $limitRows    每页显示条数
     */
    public function ccList($where = [], $currentPage = 1, $limitRows = 10)
    {
        $total = $this->where($where)->count('test_id');
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
        $where['test_id'] = $id;
        return $this->where($where)->find();
    }

    /*
     * @param $id
     */
    public function ccDel($id)
    {
        $where['test_id'] = $id;
        $row = $this->where($where)->find();
        return $row->delete();
    }

    public function ccAdd($data)
    {
        return $this->allowField(['title'])->insert($data);
    }

    public function ccEdit($data)
    {
        $where['test_id'] = $data['test_id'];
        $row = $this->where($where)->find();
        $row->title = $data['title'];
        return $row->allowField(['title'])->save();
    }
}