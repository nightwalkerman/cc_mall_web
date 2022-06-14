<?php

namespace app\home\controller;
use app\utils\alioss\Oss;

class Test 
{
    public function index()
    {
        $oss = new Oss();
        //$filePath = public_path()."static/images/1.jpeg";
        //$rs = $oss->upload("2.jpg", $filePath);
        $rs = $oss->delete("20220204/ca267eaaceb8ea12b501b8ac2ac45769.jpeg");
        dump($rs);
    }
}
