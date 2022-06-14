<?php


namespace app\manager\model;
use think\model\concern\SoftDelete;

use think\Model;

class User extends Model
{
    protected $readonly = ['username'];
    
    public function setPasswordAttr($value)
    {
        return password_hash($value,PASSWORD_BCRYPT);
    }
    
    /*
     * 根据条件返回具体列表
     * @param array $where  查询条件
     * @param $currentPage  当前页码
     * @param $limitRows    每页显示条数
     */
    public function ccList($where = [], $currentPage = 1, $limitRows = 10)
    {
        $total = $this->where($where)->count('user_id');
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
        $where['user_id'] = $id;
        return $this->where($where)->withoutField(['password','pay_password'])->find();
    }

    /*
     * @param $id
     */
    public function ccDel($id)
    {
        $where['user_id'] = $id;
        $row = $this->where($where)->find();
        return $row->delete();
    }

    public function ccAdd($data)
    {
        return $this->allowField(['title'])->insert($data);
    }

    public function ccEdit($data)
    {
        $where['user_id'] = $data['user_id'];
        $row = $this->where($where)->find();
        $row->nickname = $data['nickname'];
        $row->mobile = $data['mobile'];
        $row->address = $data['address'];
        if(isset($data['password']))
        {
            $row->password = $data['password'];
        }
        return $row->save();
    }
}