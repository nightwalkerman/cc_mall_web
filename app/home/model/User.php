<?php

namespace app\home\model;
use think\Model;
use app\utils\tools\R;
use app\utils\tools\JwtTools;

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
    
    public function ccLogin($postData)
    {
        $where['username'] = $postData['username'];
        $row = $this->where($where)->find();

        // 判断数据是否存在
        if(!$row) return R::json(400,lang('username_not_exist'),'');

        // 判断密码是否正确
        if(!password_verify($postData['password'],$row['password'])) return R::json(401,lang('username_or_password_error'),'');

        // 将登陆信息记录到 session、redis等
        $adminSession = array(
            "user_id"   => $row['user_id'],
            "username"   => $row['username']           
        );
        session('user',$adminSession);

        // 登陆成功返回
        return R::json(0,lang('login_success'),'');
    }
    
    public function appLogin($postData)
    {
        $where['username'] = $postData['username'];
        $row = $this->where($where)->find();

        // 判断数据是否存在
        if(!$row) return R::json(400,lang('username_not_exist'),'');

        // 判断密码是否正确
        if(!password_verify($postData['password'],$row['password'])) return R::json(401,lang('username_or_password_error'),'');

        // 将登陆信息记录到 session、redis等
        $adminSession = array(
            "user_id"   => $row['user_id'],
            "username"   => $row['username']           
        );
        

        // 登陆成功返回
        return R::json(0,$adminSession, JwtTools::encode($adminSession));
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
        // 先判断有没有人注册过
        $where['username'] = $data['username'];
        $row = $this->where($where)->find();
        if($row) return R::json (101, "用户已经存在");
        
        $this->save($data);
        return R::json(0, "操作成功");
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
