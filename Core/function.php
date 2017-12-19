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
        if($modelDb = \ZeroCost\Core\Register::get($str.'Model')){
            return $modelDb;
        }else{
            $model="\\Model\\{$str}";
            $modelDb = new $model();
            \ZeroCost\Core\Register::set($str.'Model',$modelDb);
            return $modelDb;
        }
    }
}


function getOption($type='get',$name=null){
    if($type=='get') $for = $_GET ;else $for = $_POST;
    $return=array();
    foreach($for as $k=>$v){
        if($k!=='c'&&$k!=='a')
        $return[$k] = htmlspecialchars(addslashes($v));
    }
    if($name) return isset($return[$name])?$return[$name]:"" ; else return $return;
}



function getCache($name){
    $fielpath = ROOTPATH.'/Cache/';
    $data = file_get_contents($fielpath.$name);
    if(!empty($data)){
        $data = json_decode($data, true);
        if(time() - $data['time'] < $data['expires_in']){
            return $data['value'];
        }
    }
    return null;
}
function setCache($name,$value,$uptime=7200){
    $fielpath = ROOTPATH.'/Cache/';
    $data['time'] = time();
    $data['value']= $value;
    $data['expires_in']= $uptime;
    $data = json_encode($data);
    $f = fopen($fielpath.$name, 'w+');
    $power = fwrite($f, $data);
    fclose($f);
    return $power;
}





function taskForWebRun($funcPath,$size){
    $callable = new $funcPath();
    if(version_compare(PHP_VERSION,'7.0.0','ge')){
        if($callable instanceof \ZeroCost\Core\Task_Php7){
            $taskName = md5(time());
            $json = json_encode(array('callback'=>$funcPath,'size'=>$size));
            setCache($taskName.'pageGoWhere',0);
            setCache('task-'.$taskName,$json);
            $url = '?m=System&c=TaskList&a=run&taskName'.$taskName.'&page=0';
            Header("Location: $url");
        }else{
            return false;
        }
    }else{
        if($callable instanceof \ZeroCost\Core\Task_Php5){
            $taskName = md5(time());
            $json = json_encode(array('callback'=>$funcPath,'size'=>$size));
            setCache($taskName.'pageGoWhere',0);
            setCache('task-'.$taskName,$json);
            $url = '?m=System&c=TaskList&a=run&taskName'.$taskName.'&page=0';
            Header("Location: $url");
        }else{
            return false;
        }
    }
}
