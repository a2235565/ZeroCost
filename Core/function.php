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
    if(!file_exists($fielpath.$name))
    {
        return null;
    }
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
            $url = '?m=System&c=TaskList&a=run&taskName='.$taskName.'&page=0';
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
            $url = '?m=System&c=TaskList&a=run&taskName='.$taskName.'&page=0';
            Header("Location: $url");
        }else{
            return false;
        }
    }
}






class zyCode{
     protected  function get_bianma($str)//等同于js的charCodeAt()
    {
        $result = array();
        for($i = 0, $l = mb_strlen($str, 'utf-8');$i < $l;++$i)
        {
            $result[] = $this->uniord(mb_substr($str, $i, 1, 'utf-8'));
        }
        return join(",", $result);
    }
    protected function uniord($str, $from_encoding = false)
    {
        $from_encoding = $from_encoding ? $from_encoding : 'UTF-8';
        if (strlen($str) == 1)
            return ord($str);
        $str = mb_convert_encoding($str, 'UCS-4BE', $from_encoding);
        $tmp = unpack('N', $str);
        return $tmp[1];
    }


    function enCodeForZy($data,$s,$salt) {
        $returnStr = '';
        $list = str_split($data);
        for($i = 0;$i<count($list);$i++){
            $temp = $this->get_bianma($list[$i]);
            $returnStr.= $s.($temp<<$salt);
        }

          return $returnStr;

    }


    function deCodeForZy($code,$s,$salt) {
         $list =  explode($s,$code);
         $returnStr = '';
        for($i =  0;$i<count($list);$i++){
            @$returnStr.=chr(($list[$i]>>$salt)*1);
        }
        return $returnStr;
    }


 }
//demo
/**
$str = (new zyCode())->enCodeForZy("<html> 打哈哈</html>","dasdkjbb",2);
echo  (new zyCode())->deCodeForZy($str,"dasdkjbb",2);
**/
