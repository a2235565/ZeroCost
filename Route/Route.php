<?php
namespace Route;
class Route{
    function run(){
        foreach($_GET as $k=>$v)
            $get[$k]=addslashes($v);
        $config = include(ROOTPATH . "/Config/Conf.php");
        $m=isset($get['m'])?$get['m']:$config['defaultModular'];
        $c=isset($get['c'])?$get['c']:'Index';
        $a=isset($get['a'])?$get['a']:'Index';
        $action="\\Project\\$m\\$c";
        if(file_exists(ROOTPATH.'/'.$action.'.php')){
            $go = new $action();
            $go->$a();
        }else{
            trigger_error('找不到您要的方法',E_USER_ERROR);
        }
    }
}