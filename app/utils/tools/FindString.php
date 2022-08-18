<?php


namespace app\utils\tools;


class FindString
{
    /*
     * 查找数组中，是否存在某字符
     */
    static public function searchKeyword($keyword, $searchArray = ["login","asyncLogin","asyncLogout"])
    {
        foreach($searchArray as $value)
        {
            if(strstr($keyword , $value) !== false)
            {
                return true;
            }
        }
        return false;
    }
    
    static function strCutByStr(&$str, $findStart, $findEnd = false, $encoding = 'utf-8') 
    {
        if (is_array($findStart)) 
        {
            if (count($findStart) === count($findEnd)) 
            {
                foreach ($findStart as $k => $v) 
                {
                    if (($result = strCutByStr($str, $v, $findEnd[$k], $encoding)) !== false) 
                    {
                        return $result;
                    }
                }
                return false;
            } 
            else 
            {
                return false;
            }
        }

        if (($start = mb_strpos($str, $findStart, 0, $encoding)) === false) 
        {
            return false;
        }

        $start += mb_strlen($findStart, $encoding);

        if ($findEnd === false) 
        {
            return mb_substr($str, $start, NULL, $encoding);
        }

        if (($length = mb_strpos($str, $findEnd, $start, $encoding)) === false) 
        {
            return false;
        }

        return mb_substr($str, $start, $length - $start, $encoding);
    }

}