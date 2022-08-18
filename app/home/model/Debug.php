<?php

namespace app\home\model;
use think\Model;
use app\utils\tools\R;

class Debug extends Model
{
    public function ccAdd($data)
    {        
        // 新增数据
        unset($data['token']);
        
        $d['log']           = R::toJsonSource($data);
        $d['system_order']  = $data['out_trade_no'];

        $this->insert($d);
        //halt($this->getLastSql());

        return R::json(0, "操作成功");
    }
}
