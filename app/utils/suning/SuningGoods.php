<?php
/**
 * 苏宁易购 商品详情采集
 */

namespace app\utils\suning;
use QL\QueryList;
use app\utils\tools\R;

class SuningGoods 
{
    static public function getDetails($suningurl) 
    {
        $txt = QueryList::get($suningurl);
        
        // 标题 
        $goods_name = $txt->find("li.line")->html();
        
        // 产品小图+大图
        $small = $txt->find(".imgzoom-thumb .imgzoom-thumb-main")->find("img")->attrs("src");
        $goods_image_small = [];
        foreach ($small as $s)
        {
            $url1 = str_replace("//", "https://", $s);
            array_push($goods_image_small,$url1);
        }
        
        $big   = $txt->find(".imgzoom-thumb .imgzoom-thumb-main")->find("img")->attrs("src-large");
        $goods_image_big = [];
        foreach($big as $b)
        {
            $url2 = str_replace("//", "https://", $b);
            array_push($goods_image_big,$url2);
        }
        
        // 说明
        $imgs2 = $txt->find("#productDetail")->find("img")->attrs("src2");
        $imgs1 = $txt->find("#productDetail")->find("img")->attrs("src");
      
        $arrs = [];       
        foreach($imgs1 as $img)
        {
            if($img)
            {
                array_push($arrs,$img);
            }            
        }
        foreach($imgs2 as $img)
        {
            if($img)
            {
                array_push($arrs,$img);
            }            
        }
        
        #颜色规格
        $color = $txt->find("#colorItemList")->find("li")->attrs("title");
        $colors= [];
        foreach ($color as $c)
        {
            if($c)
            {
                array_push($colors,$c);
            } 
        }
        
        #版本选择
        $version = $txt->find("#versionItemList")->find("li")->attrs("title");
        $versions= [];
        foreach ($version as $v)
        {
            if($v)
            {
                array_push($versions,$v);
            } 
        }
        
        $data = array(
            'goods_name'        => $goods_name,
            'goods_image_small' => R::toJsonSource($goods_image_small),
            'goods_image_big'   => R::toJsonSource($goods_image_big),
            'goods_desc'        => R::toJsonSource($arrs),
            "collection_url"    => $suningurl,
            "color"             => R::toJsonSource($colors),
            "version"           => R::toJsonSource($versions)
        );
        
        return $data;
    }
    
}
