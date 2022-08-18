<?php


namespace app\manager\model;


use think\Model;

class Admin extends Model
{
    protected $readonly = ['username','admin_id'];

    public function getEnabledAttr($value)
    {
        $status = [1=>"1" ,2=>"2"];
        return $status[$value];
    }

    public function setPasswordAttr($value)
    {
        return password_hash($value,PASSWORD_BCRYPT);
    }

    public function role()
    {
        return $this->hasOne(Role::class,'role_id','role_id');
    }

    /*
         * 根据条件返回具体列表
         * @param array $where  查询条件
         * @param $currentPage  当前页码
         * @param $limitRows    每页显示条数
         */
    public function ccList($where = [], $currentPage = 1, $limitRows = 10)
    {
        $total = $this->where($where)->count('admin_id');
        $rows  = $this->where($where)
                      ->page($currentPage,$limitRows)
                      ->withoutField("password,pay_password,status")
                      ->withJoin(['role' => ['role_name']])
                      ->select();

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
        $where['admin_id'] = $id;
        return $this->where($where)->withoutField("password,pay_password,status")->find();
    }

    /*
     * @param $id
     */
    public function ccDel($id)
    {
        $where['admin_id'] = $id;
        $row = $this->where($where)->find();
        if($row['username'] != "admin")
        {
            return $row->delete();
        }
        else
        {
            return false;
        }
    }

    public function ccAdd($data)
    {
        $where['username'] = ['eq',$data['username']];
        $row = $this->where($where)->find();
        if($row)
        {
            return false;
        }else{
            return $this->save($data);
        }

    }

    public function ccEdit($data)
    {
        $where['admin_id'] = $data['admin_id'];
        $row = $this->where($where)->find();
        $row->email     = $data['email'];
        $row->mobile    = $data['mobile'];
        $row->enabled   = $data['enabled'];
        $row->role_id   = $data['role_id'];
        $row->remark    = $data['remark'];
        if(isset($data['password']))
        {
            $row->password  = $data['password'];
        }

        return $row->save();
    }
}