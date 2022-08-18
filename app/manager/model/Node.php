<?php
/**
 * 节点模块
 */
namespace app\manager\model;
use app\utils\tools\Tree;
use think\Model;

class Node extends Model
{

    public function getNodeNameAttr($value)
    {
        return lang($value);
    }

    /**
     * 以树形（无限级分类）模式，读取节点，提供 elementui 使用
     */
    public function getNodeListTree()
    {
        $where['delete_status'] = "1";
        $rows = $this->where($where)->order('sort')->field("node_name,node_id,parent_id,node_action,action_code,sort,icon")->select();
        $menu = Tree::recursion($rows);
        return $menu;
    }

    public function getSessionListTree($loginUserMenuCode, $systemStatus = "manager_status")
    {
        $where['delete_status'] = "1";
        $where[$systemStatus] = "1";
        $field = "node_name as title,node_id,parent_id,node_action as href,action_code,sort,icon";

        if(session("adminSession.admin_id") == "1")
        {
            // 管理员读取全部
            $rows = $this->where($where)->order('sort')->field($field)->select();
        }
        else
        {
            // 其它用户读取对应角色的菜单
            $rows = $this->where($where)->whereIn('action_code',$loginUserMenuCode)->order('sort')->field($field)->select();
        }

        $menu = Tree::layui($rows);
        return $menu;
    }

}