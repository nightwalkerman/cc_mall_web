<?php


namespace app\manager\model;
use think\Model;

class Role extends Model
{
    public function getReadWriteAttr($value)
    {
        $status = [1=>"1" ,2=>"2"];
        return $status[$value];
    }

    /*
          * 根据条件返回具体列表
          * @param array $where  查询条件
          * @param $currentPage  当前页码
          * @param $limitRows    每页显示条数
          */
    public function ccList($where = [], $currentPage = 1, $limitRows = 10)
    {
        $total = $this->where($where)->count('role_id');
        $rows  = $this->where($where)->withoutField(['menu_code'])->page($currentPage,$limitRows)->select();
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
        $where['role_id'] = $id;
        return $this->where($where)->find();
    }

    /*
     * @param $id
     */
    public function ccDel($id)
    {
        $where['role_id'] = $id;
        $row = $this->where($where)->find();
        return $row->delete();
    }

    public function ccAdd($data)
    {
        return $this->insert($data);
    }

    public function ccEdit($data)
    {
        $where['role_id'] = $data['role_id'];
        $row = $this->where($where)->find();
        $row->role_name   = $data['role_name'];
        $row->action_code = $data['action_code'];
        $row->menu_code   = $data['menu_code'];
        $row->read_write  = $data['read_write'];
        return $row->allowField(['role_name','action_code','menu_code','read_write'])->save();
    }
}