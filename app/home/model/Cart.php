<?php

namespace app\home\model;
use think\Model;
use app\home\model\Goods as GoodsModel;
use app\utils\tools\R;

class Cart extends Model
{
    public function getGoodsImageSmallAttr($value)
    {
        return json_decode($value);
    }
    public function getGoodsImageBigAttr($value)
    {
        return json_decode($value);
    }
    
    /*
     * 根据条件返回具体列表
     * @param array $where  查询条件
     * @param $currentPage  当前页码
     * @param $limitRows    每页显示条数
     */
    public function ccList($where = [], $currentPage = 1, $limitRows = 10)
    {
        $total = $this->where($where)->count('cart_id');
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
        return $this->where($where)->find();
    }

    /*
     * @param $id
     */
    public function ccDel($id)
    {
        $where['cart_id'] = $id;
        $row = $this->where($where)->find();
        return $row->delete();
    }

    public function ccAdd($data)
    {
        // 先判断有没有人注册过
        $where['goods_id']      = $data['goods_id'];
        $where['delete_status'] = "1";
        $where['user_id']       = session("user.user_id");
        $row = $this->where($where)->find();
        if($row) 
        {
            // 已经存在记录，则更新购物车的数据
            $update['goods_number'] = $row->goods_number+$data['goods_number'];
            $this->allowField(["goods_number"])->where($where)->update($update);
        }
        else
        {
            // 如果不存在记录，则新增数据
            $goodsModel = new GoodsModel();
            $goods = $goodsModel->ccOne($data['goods_id']);
            $goods->goods_number = $data['goods_number'];
            $goods->user_id = session("user.user_id");
            $g = json_decode($goods,true);
            $g['goods_image_small'] = R::toJsonSource($g['goods_image_small']);
            $g['goods_image_big']   = R::toJsonSource($g['goods_image_big']);
            
//            $newGoods = [
//                "goods_id"          => $goods->goods_id,
//                "user_id"           => session("user.user_id"),
//                "goods_name"        => $goods->goods_name,
//                "goods_number"      => $data['goods_number'],
//                "goods_image_small" => $goods->goods_image_small,
//                "goods_image_big"   => $goods->goods_image_big,
//                "goods_desc"        => $goods->goods_desc,
//                "goods_price"       => $goods->goods_price,
//                "collection_url"    => $goods->collection_url,
//                "category_id"       => $goods->category_id,
//                "delete_status"     => 1,
//            ];
            
                        
            $this->insert($g);
            //halt($this->getLastSql());
        }
        return R::json(0, "操作成功");
    }
    
    public function appAdd($data)
    {
        // 先判断有没有人注册过
        $where['goods_id']      = $data['goods_id'];
        $where['delete_status'] = "1";
        $where['user_id']       = $data['user_id'];
        $where['color']         = $data['color'];
        $where['version']       = $data['version'];
        $row = $this->where($where)->find();
        if($row) 
        {
            // 已经存在记录，则更新购物车的数据
            $update['goods_number'] = $row->goods_number+$data['goods_number'];
            $this->allowField(["goods_number"])->where($where)->update($update);
        }
        else
        {
            // 如果不存在记录，则新增数据
            $goodsModel = new GoodsModel();
            $goods = $goodsModel->ccOne($data['goods_id']);
            $goods->goods_number = $data['goods_number'];
            $goods->user_id = $data['user_id'];
            $g = json_decode($goods,true);
            $g['goods_image_small'] = R::toJsonSource($g['goods_image_small']);
            $g['goods_image_big']   = R::toJsonSource($g['goods_image_big']);
            $g['color'] = $data['color'];
            $g['version'] = $data['version'];
//            $newGoods = [
//                "goods_id"          => $goods->goods_id,
//                "user_id"           => session("user.user_id"),
//                "goods_name"        => $goods->goods_name,
//                "goods_number"      => $data['goods_number'],
//                "goods_image_small" => $goods->goods_image_small,
//                "goods_image_big"   => $goods->goods_image_big,
//                "goods_desc"        => $goods->goods_desc,
//                "goods_price"       => $goods->goods_price,
//                "collection_url"    => $goods->collection_url,
//                "category_id"       => $goods->category_id,
//                "delete_status"     => 1,
//            ];
            
                        
            $this->insert($g);
            //halt($this->getLastSql());
        }
        return R::json(0, "操作成功");
    }

    public function ccEdit($data)
    {
        $where['cart_id'] = $data['cart_id'];
        $row = $this->where($where)->find();
        $row->goods_number = $data['goods_number'];
        return $row->allowField(['goods_number'])->save();
    }
    
    public function appCart($where = [], $currentPage = 1, $limitRows = 10)
    {
        $total = $this->where($where)->count('cart_id');
        $rows  = $this->where($where)->page($currentPage,$limitRows)->select();

        $cartChild = [];
        $total = 0;
        foreach ($rows as $key=>$val)
        {
            $cartChild[$key]['img']     = $val['goods_image_big'][0];
            $cartChild[$key]['title']   = $val['goods_name'];
            $cartChild[$key]['remark']  = "";
            $cartChild[$key]['color']   = $val['color'];
            $cartChild[$key]['version'] = $val['version'];
            $cartChild[$key]['price']   = $val['goods_price'];
            $cartChild[$key]['number']  = $val['goods_number'];
            $cartChild[$key]['checked'] = 1;
            $cartChild[$key]['cart_id'] = $val['cart_id'];
            $total += ($val['goods_price']*$val['goods_number']);
        }
        
        $data[0]  = array(
            "name"      => "",
            "checked"   => 1,
            "total"     => $total,
            "goods"     => $cartChild
        );
        
        return $data;
    }
    
    
}
