<?php

namespace app\home\model;
use think\Model;
use app\utils\tools\R;

class UserAddress extends Model
{
    public function getIsDefaultAttr($value)
    {
        $is_default = [1=>true ,2=>false];
        return $is_default[$value];
    }
    /*
     * 根据条件返回具体列表
     * @param array $where  查询条件
     * @param $currentPage  当前页码
     * @param $limitRows    每页显示条数
     */
    public function ccList($where = [], $currentPage = 1, $limitRows = 10)
    {
        $total = $this->where($where)->count('address_id');
        $rows  = $this->where($where)->withoutField(['user_id'])->page($currentPage,$limitRows)->select();
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
    public function ccOne($data = [])
    {
        $where['user_id'] = $data['user_id'];
        $where['address_id'] = $data['address_id'];
        return R::json(0, "操作成功",$this->where($where)->find());
    }

    /*
     * @param $id
     */
    public function ccDel($id)
    {
        $where['address_id'] = $id;
        $row = $this->where($where)->find();
        return $row->delete();
    }

    public function ccAdd($data)
    {        
        // 新增数据
        $d['user_id']   = $data['user_id'];
        $d['area']      = $data['area'];
        $d['city']      = $data['city'];
        $d['province']  = $data['province'];
        $d['address']   = $data['address'];
        $d['username']  = $data['username'];
        $d['mobile']    = $data['mobile'];

        $this->insert($d);
        //halt($this->getLastSql());

        return R::json(0, "操作成功");
    }

    public function ccEdit($data)
    {
        $where['address_id'] = $data['address_id'];
        $where['user_id']    = $data['user_id'];
        $row = $this->where($where)->find();
        $row->area      = $data['area'];
        $row->address   = $data['address'];
        $row->username  = $data['username'];
        $row->mobile    = $data['mobile'];
        $row->city      = $data['city'];
        $row->province  = $data['province'];
        return $row->save();
        
        //halt($this->getLastSql(),$row);
    }
        
}
