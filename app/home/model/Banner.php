<?php

namespace app\home\model;
use think\Model;

class Banner extends Model
{
    public function getBanner() 
    {
        return $this->limit(5)->select();
    }
}
