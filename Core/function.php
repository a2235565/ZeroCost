<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/14
 * Time: 22:31
 */
function application_log($title,$info){
    if(!is_dir(ROOTPATH.'/Log/'.date('Y-m-d',time()).'/')){
        if(!is_dir(ROOTPATH.'/Log/')){
            mkdir(ROOTPATH.'/Log/');
        }
        mkdir(ROOTPATH.'/Log/'.date('Y-m-d',time()).'/');
    }
    $filename=ROOTPATH.'/Log/'.date('Y-m-d',time()).'/DbLog.txt';
    $handle=fopen($filename,"a+");
    fwrite($handle,"$title:$info\n");
    fclose($handle);
}

function M($str=null){
    if(empty($str))
        return \ZeroCost\Core\Register::get('db');
    else{
        $model="\\Model\\{$str}";
        return new $model();
    }
}


