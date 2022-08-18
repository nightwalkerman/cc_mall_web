<?php

namespace app\manager\model;
use think\Model;
use app\utils\alioss\Oss;

class Banner extends Model
{
        /*
     * 根据条件返回具体列表
     * @param array $where  查询条件
     * @param $currentPage  当前页码
     * @param $limitRows    每页显示条数
     */
    public function ccList($where = [], $currentPage = 1, $limitRows = 10)
    {
        $total = $this->where($where)->count('banner_id');
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
     * @param $id
     */
    public function ccDel($id)
    {
        $where['banner_id'] = $id;
        $row = $this->where($where)->find();
        if($row)
        {
            //$oss = new Oss();
            //$oss->delete($row->image_name);
        }
        return $row->delete();
    }

    public function ccAdd($data)
    {
        return $this->insert($data);
    }

    
}
