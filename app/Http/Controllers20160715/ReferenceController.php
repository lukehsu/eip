<?php 
    $uri = Request::path();
    $uris = strstr($uri,'/',true);
    $form = null;
    $style = 0 ;
    $i = 0;
    $lastyear = substr($todaydate, 0,5) - 1 ;//去年年分
    $yearstart = substr($todaydate, 0,5).'01-01';//依照選擇的日期轉換每月年年初 
    $monthstart = substr($todaydate, 0,8).'01';//依照選擇的日期轉換每月月初   
    $lastyearstart = $lastyear.'-01-01';//依照選擇的日期轉換去年每年年初 
    $lastyearmonthstart = $lastyear.substr($todaydate, 4,4).'01';//依照選擇的日期轉換去年每月月初   
    $lastyearday = $lastyear.substr($todaydate, 4);//依照選擇的日期轉換去年今日
    $chardate =  str_replace('-','',$todaydate); 
    $MC = array();
    $MCC = array();
    $outcounts = array();
    $allname = array();
    $allach = array();
    $shippingd = 0;//物流每日業績
    $totaldairy = 0;
    $totalMA = 0;
    $totalMB = 0;
    $totalMAA = 0;
    $totalMBB = 0;
    /*$m = date("m",strtotime($todaydate));
    if (date("m")>=10 ) {
    	$yearstart = substr($todaydate, 0,5).'10-01';
    	$season = 'Q4';
    }
    elseif (date("m")>=7) 
    {
        $yearstart = substr($todaydate, 0,5).'07-01';
        $season = 'Q3';
    }
    elseif (date("m")>=4) 
    {
        $yearstart = substr($todaydate, 0,5).'04-01';
        $season = 'Q2';
    }
    else
    {
        $yearstart = substr($todaydate, 0,5).'01-01';
        $season = 'Q1';
    }*/
    $season = 'YTD';
     
 
 
 