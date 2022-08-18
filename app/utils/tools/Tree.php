<?php
/**
 * 无限级分类获取
 */

namespace app\utils\tools;


class Tree
{
    /*
     * 递归遍历
     * @param $data array
     * @param $id int
     * return array
     * */
    static public function recursion($data, $systemUrl = "manager", $id = 0)
    {
        $list = array();
        foreach($data as $v) 
        {
            if($v['parent_id'] == $id) 
            {
                $v['children'] = self::recursion($data, "", $v['node_id']);
                if(empty($v['children'])) 
                {
                    unset($v['children']);
                }
                array_push($list, $v);
            }
        }
        return $list;
    }

    static public function layui($data, $systemUrl = "/manager", $id = 0)
    {
        $layList = array();
        foreach($data as $v) 
        {
            $v['title'] = lang($v['title']);
            $v['target']= '_self';
            
            $v['href'] = $v['parent_id'] == "0" ? "" : $systemUrl.$v['href'];
           
            if($v['parent_id'] == $id) 
            {
                $v['child'] = self::layui($data, "", $v['node_id']);
                if(empty($v['child'])) 
                {
                    unset($v['child']);
                }
                array_push($layList, $v);
            }
        }
        return $layList;
    }
}