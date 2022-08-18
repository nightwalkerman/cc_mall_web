<?php

namespace app\api\controller;
use app\utils\tools\R;
use app\home\model\Banner   as BannerModel;
use app\home\model\Goods    as GoodsModel;
use app\home\model\Cart     as CartModel;
use app\home\model\Order    as OrderModel;
use app\home\model\User     as UserModel;
use app\home\model\UserAddress as UserAddressModel;
use app\home\model\Category as CategoryModel;
use app\home\model\Debug    as DebugModel;
use app\utils\tools\JwtTools;


class Index 
{
    public function getBanner()
    {
        $banner = new BannerModel();
        return R::json(0,'',$banner->getBanner());
    }
    
    public function hotGoods() 
    {
        $goods = new GoodsModel();
        return R::json(0,'',$goods->hotGoods());
    }
    
    public function killGoods() 
    {
        $goods = new GoodsModel();
        return R::json(0,'',$goods->killGoods());
    }
    
    public function goodsDetail() 
    {
        $goods = new GoodsModel();
        return R::json(0,'',$goods->ccOne(input("id")));
    }
    
    public function goodsList() 
    {
        $goods = new GoodsModel();
        $where = [];
        
        input('goods_name') && array_push($where,['goods_name','like','%'.input('goods_name').'%']);
        input('category_id') && array_push($where,['category_id','=',input('category_id')]);
        
        
        return R::json(0,'',$goods->goodsList(input("pageindex"),$where));
    }
    
    public function cart()
    {
        $postData = request()->getInput();
        $postData = json_decode($postData,true);

        $user = JwtTools::decode($postData['token']);
        if(!$user)
        {
            return R::json(302,"未登陆");
        }
        
        $cart = new CartModel();
        $where['user_id'] = $user->user_id;
        
        $datas = $cart->appCart($where);
        return R::json(0,$datas[0]['total'],$datas);
    }
    
    public function addCart() 
    {
        $postData = request()->getInput();
        $postData = json_decode($postData,true);

        $user = JwtTools::decode($postData['token']);
        if(!$user)
        {
            return R::json(302,"未登陆");
        }
        
        $postData['goods_number'] = 1;
        $postData['user_id'] = $user->user_id;
        
        $cart = new CartModel();
        $cart->appAdd($postData);
        return R::json(0, lang('operation_success'),"");
    }
    
    public function updateCart() 
    {
        $postData = request()->getInput();       
        $postData = json_decode($postData,true);
        
        $user = JwtTools::decode($postData['token']);
        if(!$user)
        {
            return R::json(302,"未登陆");
        }
        
        $postData['user_id'] = $user->user_id;
        
        $cart = new CartModel();
        $cart->ccEdit($postData);
        return R::json(0, lang('operation_success'),"");
    }
    
    public function deleteCart() 
    {
        $postData = request()->getInput();       
        $postData = json_decode($postData,true);
        
        $user = JwtTools::decode($postData['token']);
        if(!$user)
        {
            return R::json(302,"未登陆");
        }
        
        $postData['user_id'] = $user->user_id;
        
        $cart = new CartModel();
        $cart->ccDel($postData['cart_id']);
        return R::json(0, lang('operation_success'),"");
    }
    
    public function cartToOrder()
    {
        $postData = request()->getInput();       
        $postData = json_decode($postData,true);
        
        $user = JwtTools::decode($postData['token']);
        if(!$user)
        {
            return R::json(302,"未登陆");
        }
        
        $postData['user_id'] = $user->user_id;
        
        $order = new OrderModel();
        return $order->appCartToOrder($postData);
    }
    
    
    public function signin()
    {
        $postData = request()->getInput();       
        $postData = json_decode($postData,true);
        
        $user = new UserModel();
        return $user->appLogin($postData);
    }
    
    public function signup()
    {
        $postData = request()->getInput();       
        $postData = json_decode($postData,true);
        
        
        $user = new UserModel();
        return $user->ccAdd($postData);
    }
    
    public function jwt()
    {
        $data = [
            "aaa" => "111",
            "bbb" => "222"
        ];
        
        echo JwtTools::encode($data);
    }
    
    public function test() 
    {
        echo app_path();
    }


    public function user()
    {
        $postData = request()->getInput();       
        $postData = json_decode($postData,true);
        
        $user = JwtTools::decode($postData['token']);
        if(!$user)
        {
            return R::json(302,"未登陆");
        }
        
        $u = new UserModel();
        return R::json(0,"",$u->ccOne($user->user_id));
    }
    
    public function editUser() 
    {
        $postData = request()->getInput();       
        $postData = json_decode($postData,true);
        
        $user = JwtTools::decode($postData['token']);
        if(!$user)
        {
            return R::json(302,"未登陆");
        }
        
        $postData['user_id'] = $user->user_id;
        
        $u = new UserModel();
        return R::json(0,"",$u->ccEdit($postData));
    }
    
    public function order()
    {
        $postData = request()->getInput();       
        $postData = json_decode($postData,true);
        
        $user = JwtTools::decode($postData['token']);
        if(!$user)
        {
            return R::json(302,"未登陆");
        }
        
        $where['user_id'] = $user->user_id;
        $postData['order_status'] && $where['order_status'] = $postData['order_status'];
        $order = new OrderModel();
        return R::json(0,"",$order->ccList($where));
    }
    
    public function orderDetail() 
    {
        $postData = request()->getInput();       
        $postData = json_decode($postData,true);
        
        $user = JwtTools::decode($postData['token']);
        if(!$user)
        {
            return R::json(302,"未登陆");
        }
        
        $where['user_id'] = $user->user_id;
        if(isset($postData['id'])) $where['order_id'] = $postData['id'];
        isset($postData['system_order']) && $where['system_order'] = $postData['system_order'];
        
        $order = new OrderModel();
        return R::json(0,"",$order->appOne($where));
    }
    
    public function address() 
    {
        $postData = request()->getInput();       
        $postData = json_decode($postData,true);
        
        $user = JwtTools::decode($postData['token']);
        if(!$user)
        {
            return R::json(302,"未登陆");
        }
        $where['user_id'] = $user->user_id;
        $address = new UserAddressModel();
        return R::json(0,"",$address->ccList($where));
    }
    
    public function getAddress()
    {
        $postData = request()->getInput();       
        $postData = json_decode($postData,true);
        
        $user = JwtTools::decode($postData['token']);
        if(!$user)
        {
            return R::json(302,"未登陆");
        }
        $where['user_id']    = $user->user_id;
        $where['address_id'] = $postData['address_id'];
        $address = new UserAddressModel();
        return $address->ccOne($where);
    }
    
    public function addAddress() 
    {
        $postData = request()->getInput();       
        $postData = json_decode($postData,true);
        
        $user = JwtTools::decode($postData['token']);
        if(!$user)
        {
            return R::json(302,"未登陆");
        }
        $postData['user_id'] = $user->user_id;
        $address = new UserAddressModel();
        return $address->ccAdd($postData);
    }
    
    public function editAddress() 
    {
        $postData = request()->getInput();       
        $postData = json_decode($postData,true);
        
        $user = JwtTools::decode($postData['token']);
        if(!$user)
        {
            return R::json(302,"未登陆");
        }
        $postData['user_id'] = $user->user_id;
        $address = new UserAddressModel();
        
        return R::json(0, "操作成功", $address->ccEdit($postData));
    }
    
    public function category()
    {
        $category = new CategoryModel();
        return R::json(0,"",$category->topMenu());
    }
    
    public function categoryGoods() 
    {
        $goods = new GoodsModel();
        $where['category_id'] = input("category_id");
        return R::json(0,'',$goods->goodsList(input("pageindex"),$where));
    }
    
    
    public function notify() 
    {
        // 测试，不作签名判断。
        // 文档地址：https://open.alipay.com/api/detail?abilityCode=SM010000000000001001
        $postData = input("request.");
        $debug = new DebugModel();
        $debug->ccAdd($postData);
        if($postData['trade_status'] == "TRADE_SUCCESS")
        {
            $where['system_order'] = $postData['out_trade_no'];
            $where['order_amount'] = $postData['receipt_amount'];
            $orderModel = new OrderModel();
            $order = $orderModel->payOne($where);
            return $order;
        }
        else
        {
            echo "支付宝订单状态不正确";
        }
    }
    
}
