<?php

namespace app\home\model;
use think\Model;
use app\utils\tools\R;
use app\home\model\Cart as CartModel;

class Order extends Model
{
//    public function getOrderAmountAttr($value)
//    {
//        return number_format($value,2,".",",");
//    }
    
    public function getPayStatusAttr($value)
    {
        $status = [1=>"支付成功" ,2=>"支付失败", 3=>"退货退款", 4=>"等待支付"];
        return $status[$value];
    }
    
    public function getOrderStatusAttr($value)
    {
        $status = [1=>"待支付" ,2=>"待发货", 3=>"待收货", 4=>"待评价"];
        return $status[$value];
    }
       
    // 模型关联
    public function orderGoods()
    {
        return $this->hasMany(OrderGoods::class,'system_order',"system_order");
    }

    public function cartToOrder($postData)
    {
        $user_id = session("user.user_id");
        $order_sn= R::orderSn();
        
        // 根据session读取购物车的信息
        $whereCart['user_id'] = $user_id;
        $whereCart['delete_status'] = "1";
        $cart = new CartModel();
        $cartGoods = $cart->where($whereCart)->select();
        $orderAmount = 0;
        $newCartGoods = [];
        foreach ($cartGoods as $key=>$val)
        {
            $newCartGoods[$key]['user_id']              = $user_id;
            $newCartGoods[$key]['system_order']         = $order_sn;
            $newCartGoods[$key]['goods_id']             = $val['goods_id'];
            $newCartGoods[$key]['goods_name']           = $val['goods_name'];
            $newCartGoods[$key]['goods_image_small']    = $val['goods_image_small'];
            $newCartGoods[$key]['goods_image_big']      = $val['goods_image_big'];
            $newCartGoods[$key]['goods_desc']           = $val['goods_desc'];
            $newCartGoods[$key]['goods_price']          = $val['goods_price'];
            $newCartGoods[$key]['goods_number']         = $val['goods_number'];
            $newCartGoods[$key]['collection_url']       = $val['collection_url'];
            $newCartGoods[$key]['category_id']          = $val['category_id'];
            $orderAmount += ($val['goods_price'] * $val['goods_number']);
        }
        
        // 组合购物车所有数据统计至订单表
        $order = [
            "user_id"       => $user_id,
            "system_order"  => $order_sn,
            "order_amount"  => $orderAmount,
            "pay_amount"    => $orderAmount,
            "name"          => $postData['nickname'],
            "mobile"        => $postData['mobile'],
            "address"       => $postData['address'],
        ];
        
        // 入库操作
        // 开启事务
        //halt(json_decode($cartGoods,true));
        $this->startTrans();
        try 
        {
            $this->insert($order);
            $this->orderGoods()->insertAll($newCartGoods);
            $cart->where($whereCart)->delete();
            // 提交事务
            $this->commit();
            return R::json(0,"操作成功");
        }catch (\Exception $e){
            // 事务回滚           
            $this->rollback();
            return R::json(1,"操作失败");
        }

    }
    
    public function appCartToOrder($postData)
    {
        $user_id = $postData['user_id'];
        $order_sn= R::orderSn();
        
        // 根据session读取购物车的信息
        $whereCart['user_id'] = $user_id;
        $whereCart['delete_status'] = "1";
        $cart = new CartModel();
        $cartGoods = $cart->where($whereCart)->select();
        $orderAmount = 0;
        $newCartGoods = [];
        foreach ($cartGoods as $key=>$val)
        {
            $newCartGoods[$key]['user_id']              = $user_id;
            $newCartGoods[$key]['system_order']         = $order_sn;
            $newCartGoods[$key]['goods_id']             = $val['goods_id'];
            $newCartGoods[$key]['goods_name']           = $val['goods_name'];
            $newCartGoods[$key]['goods_image_small']    = R::toJsonSource($val['goods_image_small']);
            $newCartGoods[$key]['goods_image_big']      = R::toJsonSource($val['goods_image_big']);
            $newCartGoods[$key]['goods_desc']           = R::toJsonSource($val['goods_desc']);
            $newCartGoods[$key]['goods_price']          = $val['goods_price'];
            $newCartGoods[$key]['goods_number']         = $val['goods_number'];
            $newCartGoods[$key]['collection_url']       = $val['collection_url'];
            $newCartGoods[$key]['category_id']          = $val['category_id'];
            $newCartGoods[$key]['color']                = $val['color'];
            $newCartGoods[$key]['version']              = $val['version'];
            $orderAmount += ($val['goods_price'] * $val['goods_number']);
        }
        
        // 组合购物车所有数据统计至订单表
        $order = [
            "user_id"       => $user_id,
            "system_order"  => $order_sn,
            "order_amount"  => $orderAmount,
            "pay_amount"    => $orderAmount,
            "username"      => $postData['username'],
            "mobile"        => $postData['mobile'],
            "address"       => $postData['province'].",".$postData['city'].",".$postData['area'].",".$postData['address'],
        ];
        
        // 入库操作
        // 开启事务
        //halt(json_decode($cartGoods,true));
        $this->startTrans();
        try 
        {
            $this->insert($order);
            $this->orderGoods()->insertAll($newCartGoods);
            $cart->where($whereCart)->delete();
            // 提交事务
            $this->commit();
            return R::json(0,$order_sn);
        }catch (Exception $e){
            // 事务回滚           
            $this->rollback();
            return R::json(1,"操作失败");
        }

    }
    
    /*
     * 根据条件返回具体列表
     * @param array $where  查询条件
     * @param $currentPage  当前页码
     * @param $limitRows    每页显示条数
     */
    public function ccList($where = [], $currentPage = 1, $limitRows = 10)
    {
        $total = $this->where($where)->count('order_id');
        $rows  = $this->with("orderGoods")->where($where)->page($currentPage,$limitRows)->order("order_id desc")->select();
        //$rows->orderGoods;
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
            "order_id"   => $row['order_id'],
            "username"   => $row['username']           
        );
        session('user',$adminSession);

        // 登陆成功返回
        return R::json(0,lang('login_success'),'');
    }

    /*
     * 获取单条记录信息
     * @param $id  测试内容ID
     * @return     返回单条内容详情
     */
    public function ccOne($id)
    {
        $where['order_id'] = $id;
        $where['user_id'] = session("user.user_id");
        $row = $this->with("orderGoods")->where($where)->find();
        return $row;
    }
    
    public function appOne($data)
    {
//        $where['order_id'] = $data['order_id'];
//        $where['user_id']  = $data['user_id'];
        $row = $this->with("orderGoods")->where($data)->find();
        return $row;
    }
    
    public function payOne($where)
    {
        $order = $this->where($where)->find();
        
        if(!$order) {
            return "订单不存在";
        }

        if($order->pay_status == "支付成功") {
            return "success";
        }

        //return "pay_status:".$order->pay_status;
        
        if($order->pay_status == "等待支付") {
            $order->pay_status = 1;
            $order->order_status = 2;
            $order->allowField(['pay_status','order_status'])->save();
            return "success";
        }
        
        return "未知状态";
    }

    /*
     * @param $id
     */
    public function ccDel($id)
    {
        $where['order_id'] = $id;
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
    
}
