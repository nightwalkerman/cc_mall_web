<?php

namespace app\manager\model;
use think\Model;

class Config extends Model
{
    public function getConfig()
    {
        $where['config_id'] = "1";
        return $this->where($where)->find();
    }
}
