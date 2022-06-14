<?php


namespace app\manager\controller;
use app\manager\model\Node as NodeModel;
use app\utils\tools\R;

class Node
{

    public function menuJson()
    {
        $node = new NodeModel();
        return R::json(0,'',$node->getNodeListTree());
    }
}