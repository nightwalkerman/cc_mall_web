<?php

namespace app\manager\model;
use think\Model;
use app\manager\model\OrderGoods;

class Order extends Model
{
    public function getOrderAmountAttr($value)
    {
        return number_format($value,2);
    }
    
    public function getRateCostAttr($value)
    {
        return ($value*100)."%";
    }
    
    public function getRateSellAttr($value)
    {
        return ($value*100)."%";
    }
    
    public function getPayStatusAttr($value)
    {
        $status = [1=>"支付成功" ,2=>"支付失败", 3=>"退货退款", 4=>"等待支付"];
        return $status[$value];
    }
    public function setPayStatusAttr($value)
    {
        $status = ["支付成功"=>1 ,"支付失败"=>2, "退货退款"=>3, "等待支付"=>4];
        return $status[$value];
    }
    
    // 模型关联
    public function orderGoods()
    {
        return $this->hasMany(OrderGoods::class,'system_order',"system_order");
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
        
        $rows  = $this->where($where)->page($currentPage,$limitRows)->order("add_time desc")->select();
        
        $data  = array(
            "page" => $currentPage,
            "limit"=> $limitRows,
            "total"=> $total,
            "items"=> $rows
        );      
        return $data;
    }

    /*
     * 获取单条记录信息
     * @param $id  测试内容ID
     * @return     返回单条内容详情
     */
    public function ccOne($id)
    {
        $where['order_id'] = $id;
        $row = $this->where($where)->find();
        $row->orderGoods;
        return $row;
    }

    public function ccEdit($data)
    {
        $where['order_id'] = $data['order_id'];
        $row = $this->where($where)->find();
        $row->system_order = $data['system_order'];
        $row->order_amount = $data['order_amount'];
        $row->add_time = $data['add_time'];
        $row->address = $data['address'];
        $row->express_number = $data['express_number'];
        $row->mobile = $data['mobile'];
        $row->order_remark = $data['order_remark'];
        $row->pay_status = $data['pay_status'];
        $row->username = $data['username'];
        
        // 因为没有1对多关联修改功能，所能只能调用模型
        $og = new OrderGoods();
        $orderGoods = $data['orderGoods'];
        foreach ($orderGoods as $key=>$v)
        {
            $orderGoods[$key]['system_order'] = $data['system_order'];
        }
        $og->saveAll($orderGoods);
        
        return $row->save();
    }
}
