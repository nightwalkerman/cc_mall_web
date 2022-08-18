<?php

namespace app\utils\time;

class TimeQuery
{
    //------------------------------日期时间操作----------------------------------
    
    // 根据日期，补全当天开始时间和结束时间
    static public function getDateAreaBySelf($startTime = '', $endTime = '', $type = 'eq') 
    {
        $map = array();
        $g = $type == 'eq' ? 'EGT' : 'GT';
        $l = $type == 'eq' ? 'ELT' : 'LT';

        if ($startTime && $endTime) {
            $map[] = array($g, $startTime);
            $map[] = array($l, $endTime);
        } else {

            $startTime && $map = array($g, $startTime);
            $endTime   && $map = array($l, $endTime);
        }
        return $map;
    }
    
    // 根据日期，补全当天开始时间和结束时间
    static public function getDateAreaTimeByFullDay($startTime = '', $endTime = '', $type = 'eq') 
    {
        $map = array();
        $g = $type == 'eq' ? 'EGT' : 'GT';
        $l = $type == 'eq' ? 'ELT' : 'LT';

        if ($startTime && $endTime) {
            $map[] = array($g, $startTime . " 00:00:00");
            $map[] = array($l, $endTime . " 23:59:59");
        } else {

            $startTime && $map = array($g, $startTime . " 00:00:00");
            $endTime   && $map = array($l, $endTime . " 23:59:59");
        }
        return $map;
    }

    
    //------------------------------时间戳操作----------------------------------
    
    // 根据日期，将日期转为时间戳
    static public function getDateAreaIntBySelf($startTime = '', $endTime = '', $type = 'eq') 
    {
        $map = array();
        $g = $type == 'eq' ? 'EGT' : 'GT';
        $l = $type == 'eq' ? 'ELT' : 'LT';

        if ($startTime && $endTime) {
            $map[] = array($g, strtotime($startTime));
            $map[] = array($l, strtotime($endTime));
        } else {
            $startTime && $map = array($g, strtotime($startTime));
            $endTime   && $map = array($l, strtotime($endTime));
        }
        return $map;
    }

    // 根据日期，补全当天开始时间和结束时间，并转为时间戳
    static public function getDateAreaTimeIntByFullDay($startTime = '', $endTime = '', $type = 'eq') 
    {
        $map = array();
        $g = $type == 'eq' ? 'EGT' : 'GT';
        $l = $type == 'eq' ? 'ELT' : 'LT';

        if ($startTime && $endTime) {
            $map[] = array($g, strtotime($startTime . " 00:00:00"));
            $map[] = array($l, strtotime($endTime . " 23:59:59"));
        } else {
            $startTime && $map = array($g, strtotime($startTime . " 00:00:00"));
            $endTime   && $map = array($l, strtotime($endTime . " 23:59:59"));
        }
        return $map;
    }  

}
